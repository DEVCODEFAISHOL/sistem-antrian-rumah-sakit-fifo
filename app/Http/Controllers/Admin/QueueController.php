<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallHistory;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\PoliQuota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $queues = Queue::with(['patient', 'poli', 'dokter'])
            ->whereDate('checkup_date', $today)
            ->orderBy('queue_number')
            ->get();

        // Statistik untuk dashboard cards
        $stats = [
            'total' => $queues->count(),
            'waiting' => $queues->where('status', 'waiting')->count(),
            'called' => $queues->where('status', 'called')->count(),
            'completed' => $queues->where('status', 'completed')->count(),
            'skipped' => $queues->where('status', 'skipped')->count(),
        ];

        // Data kuota per poli hari ini
        $poliQuotas = PoliQuota::with('poli')
            ->where('quota_date', $today)
            ->get();

        return view('admin.queues.index', compact('queues', 'stats', 'poliQuotas'));
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
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'poli_id' => 'required|exists:polis,id',
            'dokter_id' => 'nullable|exists:dokters,id',
            'priority' => 'required|in:ringan,sedang,berat',
            'appointment_time' => 'nullable|date_format:H:i',
            'checkup_date' => 'required|date|after_or_equal:today',
            'complaint' => 'nullable|string|max:1000',
            'keterangan' => 'nullable|string|max:500',
            'jenis_kunjungan' => 'required|in:baru,lama',
            'is_emergency' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // 1. Cek kuota poli untuk tanggal yang dipilih
            $checkupDate = Carbon::parse($request->checkup_date);
            $poliQuota = $this->checkAndUpdatePoliQuota($request->poli_id, $checkupDate);

            if (!$poliQuota) {
                return back()->with('error', 'Kuota untuk poli ini pada tanggal tersebut sudah penuh!');
            }

            // 2. Cek duplikasi pasien di poli yang sama pada hari yang sama
            $existingQueue = Queue::where('patient_id', $request->patient_id)
                ->where('poli_id', $request->poli_id)
                ->whereDate('checkup_date', $checkupDate)
                ->whereIn('status', ['waiting', 'called'])
                ->first();

            if ($existingQueue) {
                return back()->with('error', 'Pasien sudah terdaftar di poli ini pada tanggal yang sama!');
            }

            // 3. Generate nomor antrian
            $queueNumber = $this->generateQueueNumber($request->poli_id, $checkupDate);

            // 4. Hitung estimasi waktu tunggu
            $estimatedTime = $this->calculateEstimatedWaitingTime($request->poli_id, $checkupDate);

            // 5. Buat antrian baru
            $queue = Queue::create([
                'patient_id' => $request->patient_id,
                'poli_id' => $request->poli_id,
                'dokter_id' => $request->dokter_id,
                'queue_number' => $queueNumber,
                'priority' => $request->priority,
                'appointment_time' => $request->appointment_time,
                'checkup_date' => $checkupDate,
                'complaint' => $request->complaint,
                'keterangan' => $request->keterangan,
                'jenis_kunjungan' => $request->jenis_kunjungan,
                'is_emergency' => $request->boolean('is_emergency'),
                'estimated_waiting_time' => $estimatedTime,
                'status' => 'waiting'
            ]);

            // 6. Update current_count di poli_quotas
            $poliQuota->increment('current_count');

            DB::commit();
        return redirect()->route('admin.queues.index')
            ->with('success', 'Antrian berhasil ditambahkan.');
        }catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan antrian. Silakan coba lagi.');
        }
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

    /**
     * Get available poli quotas for AJAX
     */
    public function getPoliQuota(Request $request)
    {
        $poliId = $request->poli_id;
        $date = $request->date ?? Carbon::today()->format('Y-m-d');

        $poliQuota = PoliQuota::where('poli_id', $poliId)
            ->where('quota_date', $date)
            ->first();

        $poli = Poli::find($poliId);

        if (!$poliQuota) {
            $maxQuota = $poli->kapasitas_harian ?? 20;
            $available = $maxQuota;
            $used = 0;
        } else {
            $maxQuota = $poliQuota->max_quota;
            $available = $maxQuota - $poliQuota->current_count;
            $used = $poliQuota->current_count;
        }

        return response()->json([
            'available' => $available,
            'used' => $used,
            'max_quota' => $maxQuota,
            'is_full' => $available <= 0,
            'poli_name' => $poli->nama
        ]);
    }

    /**
     * Cek dan update kuota poli
     */
    private function checkAndUpdatePoliQuota($poliId, $checkupDate)
    {
        $poli = Poli::find($poliId);
        $dateString = $checkupDate->format('Y-m-d');

        // Cari atau buat record poli_quotas
        $poliQuota = PoliQuota::firstOrCreate(
            [
                'poli_id' => $poliId,
                'quota_date' => $dateString
            ],
            [
                'max_quota' => $poli->kapasitas_harian ?? 20,
                'current_count' => 0
            ]
        );

        // Cek apakah kuota masih tersedia
        if ($poliQuota->current_count >= $poliQuota->max_quota) {
            return null; // Kuota penuh
        }

        return $poliQuota;
    }

    /**
     * Generate nomor antrian
     */
    private function generateQueueNumber($poliId, $checkupDate)
    {
        $poli = Poli::find($poliId);
        $dateString = $checkupDate->format('ymd'); // Format: YYMMDD

        $lastQueue = Queue::where('poli_id', $poliId)
            ->whereDate('checkup_date', $checkupDate)
            ->orderBy('queue_number', 'desc')
            ->first();

        if ($lastQueue) {
            // Extract nomor urut dari queue_number terakhir
            $lastNumber = intval(substr($lastQueue->queue_number, -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $poli->kode_poli . $dateString . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Hitung estimasi waktu tunggu
     */
    private function calculateEstimatedWaitingTime($poliId, $checkupDate)
    {
        $waitingQueues = Queue::where('poli_id', $poliId)
            ->whereDate('checkup_date', $checkupDate)
            ->whereIn('status', ['waiting', 'called'])
            ->count();

        // Asumsi: setiap pasien membutuhkan 15 menit
        return $waitingQueues * 15;
    }

}
