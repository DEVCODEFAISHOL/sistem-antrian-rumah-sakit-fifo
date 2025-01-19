<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallHistory;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\Dokter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function index()
    {
        // Ambil semua antrian hari ini dengan relasi pasien, poli dan dokter
         $queues = Queue::with(['patient', 'poli','dokter'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.queues.index', compact('queues'));
    }


  public function create()
    {
         // Ambil data pasien, poli, dan dokter untuk form tambah antrian
        $patients = Patient::all();
         $polis = Poli::where('status', 'aktif')->get();
         $dokters = Dokter::all();

         return view('admin.queues.create', compact('patients', 'polis','dokters'));
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

        return redirect()->route('admin.queues.index')
            ->with('success', 'Antrian berhasil ditambahkan.');
    }

     public function show(Queue $queue)
    {
        $queue->load(['patient', 'poli','dokter']);
         return view('admin.queues.show', compact('queue'));
    }

   public function edit(Queue $queue)
    {
         // Ambil data pasien, poli, dan dokter untuk form edit antrian
        $patients = Patient::all();
         $polis = Poli::where('status', 'aktif')->get();
         $dokters = Dokter::all();

        return view('admin.queues.edit', compact('queue', 'patients', 'polis','dokters'));
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
           'is_emergency' => 'sometimes|boolean', // Ubah validasi jadi sometimes|boolean
        ]);

       return redirect()->route('admin.queues.index')
            ->with('success', 'Antrian berhasil diperbarui.');
    }

    public function destroy(Queue $queue)
    {
          try {
            DB::beginTransaction();
            $queue->delete();
            DB::commit();
             return redirect()->route('admin.queues.index')
            ->with('success', 'Antrian berhasil dihapus.');
        } catch (\Exception $e) {
              DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus antrian. Silakan coba lagi.' . $e->getMessage());
        }
    }

     public function history()
    {
        // Ambil semua riwayat antrian dengan relasi pasien, poli, dan riwayat panggilan
       $queues = Queue::with(['patient', 'poli','dokter','callHistories' => function ($query) {
            $query->where('status', 'called')->orderBy('called_time', 'desc');
        }])
           ->orderBy('created_at', 'desc')
            ->get();

         return view('admin.queues.history', compact('queues'));
    }

   public function printQueue(Queue $queue)
    {
        $queue->load(['patient', 'poli','dokter']);
        return view('admin.queues.print', compact('queue'));
    }

    public function callQueue(Queue $queue)
    {
        // Perbarui status antrian menjadi "called"
        $queue->update([
            'status' => 'called',
            'called_time' => now()->format('H:i:s'),
       ]);

        // Simpan riwayat pemanggilan
        CallHistory::create([
            'queue_id' => $queue->id,
            'called_time' => now()->format('H:i:s'),
            'status' => 'called',
        ]);

        Session::flash('success', 'Antrian berhasil dipanggil.');
       return redirect()->route('admin.dashboard');
    }

    public function skipQueue($queueId)
    {
         // Ambil antrian berdasarkan ID
        $queue = Queue::findOrFail($queueId);

       // Perbarui status antrian menjadi "skipped"
         $queue->update(['status' => 'skipped']);

        // Simpan riwayat pemanggilan dengan status "skipped"
         CallHistory::create([
            'queue_id' => $queue->id,
            'called_time' => now()->format('H:i:s'),
             'status' => 'skipped',
        ]);

        Session::flash('success', 'Antrian berhasil dilewati.');
          return redirect()->route('admin.dashboard');
    }


    public function completeQueue($queueId)
    {
          // Ambil antrian berdasarkan ID
        $queue = Queue::findOrFail($queueId);

        // Perbarui status antrian menjadi "completed"
         $queue->update(['status' => 'completed']);

        // Simpan riwayat pemanggilan dengan status "completed"
        CallHistory::create([
            'queue_id' => $queue->id,
             'called_time' => now()->format('H:i:s'),
            'status' => 'completed',
        ]);

         Session::flash('success', 'Antrian berhasil diselesaikan.');
        return redirect()->route('admin.dashboard');
    }
}
