<?php

namespace App\Http\Controllers\Staff;

use App\Models\Poli;
use App\Models\Queue;
use App\Models\Dokter;
use App\Models\Patient;
use App\Models\CallHistory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; // Import Carbon untuk manipulasi waktu

class QueueController extends Controller
{
    public function index()
    {
        // Ambil semua antrian hari ini dengan relasi pasien, poli, dan dokter
        $queues = Queue::with(['patient', 'poli', 'dokter'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('staff.queues.index', compact('queues'));
    }
    public function create()
    {
        // Ambil data pasien, poli, dan dokter untuk form tambah antrian
        $patients = Patient::all();
        $polis = Poli::where('status', 'aktif')->get();
        $dokters = Dokter::all();

        return view('staff.queues.create', compact('patients', 'polis', 'dokters'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'poli_id' => 'required|exists:polis,id',
            'dokter_id' => 'nullable|exists:dokters,id',
            'priority' => 'required|in:ringan,sedang,berat',
            'appointment_time' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string|max:255',
            'checkup_date' => 'required|date',
            'jenis_kunjungan' => 'required|in:baru,lama',
            'complaint' => 'nullable|string',
            'is_emergency' => 'sometimes|boolean',
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Mulai transaksi database
        DB::transaction(function () use ($request) {
            // Generate nomor antrian
            $queueNumber = Queue::generateQueueNumber($request->poli_id);

            // Buat antrian baru
            Queue::create([
                'patient_id' => $request->patient_id,
                'poli_id' => $request->poli_id,
                'dokter_id' => $request->dokter_id,
                'queue_number' => $queueNumber,
                'priority' => $request->priority,
                'appointment_time' => $request->appointment_time,
                'status' => 'waiting',
                'keterangan' => $request->keterangan,
                'checkup_date' => $request->checkup_date,
                'jenis_kunjungan' => $request->jenis_kunjungan,
                'complaint' => $request->complaint,
                'is_emergency' => $request->is_emergency ? true : false,
            ]);
        });

        return redirect()->route('staff.queues.index')
            ->with('success', 'Antrian berhasil ditambahkan.');
    }

    public function show(Queue $queue)
    {
        $queue->load(['patient', 'poli', 'dokter']);
        return view('staff.queues.show', compact('queue'));
    }
    public function edit(Queue $queue)
    {
        // Ambil data pasien dan poli untuk form edit antrian
        $patients = Patient::all();
        $polis = Poli::where('status', 'aktif')->get();
        $dokters = Dokter::all();

        return view('staff.queues.edit', compact('queue', 'patients', 'polis', 'dokters'));
    }

    public function update(Request $request, Queue $queue)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'poli_id' => 'required|exists:polis,id',
            'dokter_id' => 'nullable|exists:dokters,id',
            'priority' => 'required|in:ringan,sedang,berat',
            'appointment_time' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string|max:255',
            'checkup_date' => 'required|date',
            'jenis_kunjungan' => 'required|in:baru,lama',
            'complaint' => 'nullable|string',
            'is_emergency' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update data antrian
        $queue->update([
            'patient_id' => $request->patient_id,
            'poli_id' => $request->poli_id,
            'dokter_id' => $request->dokter_id,
            'priority' => $request->priority,
            'appointment_time' => $request->appointment_time,
            'keterangan' => $request->keterangan,
            'checkup_date' => $request->checkup_date,
            'jenis_kunjungan' => $request->jenis_kunjungan,
            'complaint' => $request->complaint,
            'is_emergency' => $request->is_emergency ? true : false,
        ]);

        return redirect()->route('staff.queues.index')
            ->with('success', 'Antrian berhasil diperbarui.');
    }

    public function destroy(Queue $queue)
    {
        // Hapus antrian
        $queue->delete();

        return redirect()->route('staff.queues.index')
            ->with('success', 'Antrian berhasil dihapus.');
    }

    public function today()
    {
        // Ambil semua antrian hari ini dengan relasi pasien dan poli
        $queues = Queue::with(['patient', 'poli', 'dokter'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();
        return view('staff.queues.today', compact('queues'));
    }

    public function history()
    {
        // Ambil semua riwayat antrian dengan relasi pasien, poli, dan riwayat panggilan
        $queues = Queue::with(['patient', 'poli', 'dokter', 'callHistories' => function ($query) {
            $query->where('status', 'called')->orderBy('called_time', 'desc');
        }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.queues.history', compact('queues'));
    }
    public function review(Queue $queue)
    {
        // Load relasi data
        $queue->load(['patient', 'poli', 'dokter']);

        // Validasi data relasi
        if (!$queue->patient || !$queue->poli || !$queue->dokter) {
            Log::error('Data patient, poli, atau dokter tidak ditemukan ketika review tiket', [
                'queue_id' => $queue->id
            ]);
            return redirect()->back()->with('error', 'Data pasien, poli, atau dokter tidak ditemukan.');
        }

        // Tampilkan halaman review
        return view('staff.queues.preview', compact('queue'));
    }
    public function printQueue(Queue $queue)
    {
        try {
            // Validasi status antrian
            if (!in_array($queue->status, ['waiting', 'done'])) {
                Log::warning('Gagal mencoba cetak tiket. Status antrian bukan waiting atau done', [
                    'queue_id' => $queue->id,
                    'status' => $queue->status
                ]);
                return redirect()->back()->with('error', 'Tiket antrian hanya dapat dicetak jika status masih menunggu atau sudah selesai.');
            }

            // Load relasi data
            $queue->load(['patient', 'poli', 'dokter']);

            // Validasi data relasi
            if (!$queue->patient || !$queue->poli || !$queue->dokter) {
                Log::error('Data patient, poli, atau dokter tidak ditemukan ketika cetak tiket', [
                    'queue_id' => $queue->id
                ]);
                return redirect()->back()->with('error', 'Data pasien, poli, atau dokter tidak ditemukan.');
            }

            // Generate PDF
            $pdf = $this->generatePdf($queue);

            // Log sukses
            Log::info('Tiket antrian berhasil dicetak', [
                'queue_id' => $queue->id,
                'queue_number' => $queue->queue_number
            ]);

            // Simpan pesan sukses ke session
            session()->flash('success', 'Tiket antrian berhasil dicetak.');

            // Download PDF dengan nama file yang sesuai
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, 'tiket_antrian_' . $queue->queue_number . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mencetak tiket', [
                'queue_id' => $queue->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencetak tiket: ' . $e->getMessage());
        }
    }

    private function generatePdf(Queue $queue)
    {
        try {
            $ticket_number = $queue->queue_number;
            $currentDateTime = Carbon::now();

            // Generate PDF
            $pdf = Pdf::loadView('staff.queues.print', compact('queue', 'ticket_number', 'currentDateTime'));
            $pdf->setPaper([0, 0, 566.92913, 566.92913], 'portrait');

            return $pdf;

        } catch (\Exception $e) {
            Log::error('Gagal mencetak tiket antrian', [
                'queue_id' => $queue->id,
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Gagal membuat tiket PDF: ' . $e->getMessage());
        }
    }
    public function call(Queue $queue)
    {
        // Perbarui status antrian menjadi "called"
        $queue->update([
            'status' => 'called',
            'called_time' => now()->format('H:i:s'), // Simpan waktu pemanggilan dalam format H:i:s
        ]);

        // Simpan riwayat pemanggilan
        CallHistory::create([
            'queue_id' => $queue->id,
            'called_time' => now()->format('H:i:s'), // Simpan waktu pemanggilan dalam format H:i:s
            'status' => 'called',
        ]);

        Session::flash('success', 'Antrian berhasil dipanggil.');
        return redirect()->route('staff.dashboard');
    }
    public function complete(Queue $queue)
    {
        // Perbarui status antrian menjadi "completed"
        $queue->update(['status' => 'completed']);

        // Simpan riwayat pemanggilan dengan status "completed"
        CallHistory::create([
            'queue_id' => $queue->id,
            'called_time' => now()->format('H:i:s'), // Simpan waktu pemanggilan dalam format H:i:s
            'status' => 'completed',
        ]);

        Session::flash('success', 'Antrian berhasil diselesaikan.');
        return redirect()->route('staff.dashboard');
    }

    public function skip(Queue $queue)
    {
        // Perbarui status antrian menjadi "skipped"
        $queue->update(['status' => 'skipped']);

        // Simpan riwayat pemanggilan dengan status "skipped"
        CallHistory::create([
            'queue_id' => $queue->id,
            'called_time' => now()->format('H:i:s'), // Simpan waktu pemanggilan dalam format H:i:s
            'status' => 'skipped',
        ]);

        Session::flash('success', 'Antrian berhasil dilewati.');
        return redirect()->route('staff.dashboard');
    }
    public function dashboard()
    {
        // Ambil semua antrian hari ini
        $queues = Queue::with(['patient', 'poli', 'dokter'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('staff.queues.dashboard', compact('queues'));
    }

    public function current()
    {
        // Ambil antrian saat ini (status 'waiting')
        $currentQueue = Queue::with(['patient', 'poli', 'dokter'])
            ->where('status', 'waiting')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->first();

        return view('staff.queues.current', compact('currentQueue'));
    }


    public function waiting()
    {
        // Ambil semua antrian dengan status waiting
        $waitingQueues = Queue::with(['patient', 'poli', 'dokter'])
            ->where('status', 'waiting')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('staff.queues.waiting', compact('waitingQueues'));
    }
}
