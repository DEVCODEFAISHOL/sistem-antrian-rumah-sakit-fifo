<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\PoliQuota;
use App\Models\Dokter;
use App\Models\CallHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        return view('staff.queues.index', compact('queues', 'stats', 'poliQuotas'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nama')->get();
        $polis = Poli::where('status', 'aktif')->orderBy('nama')->get();
        $dokters = Dokter::where('status', 'aktif')->orderBy('nama')->get();

        return view('staff.queues.create', compact('patients', 'polis', 'dokters'));
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

            return redirect()->route('staff.queues.index')
                ->with('success', "Antrian berhasil ditambahkan dengan nomor: {$queueNumber}");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Queue $queue)
    {
        $queue->load(['patient', 'poli', 'dokter', 'callHistories']);

        return view('staff.queues.show', compact('queue'));
    }

    public function edit(Queue $queue)
    {
        $patients = Patient::orderBy('nama')->get();
        $polis = Poli::where('status', 'aktif')->orderBy('nama')->get();
        $dokters = Dokter::where('status', 'aktif')->orderBy('nama')->get();

        return view('staff.queues.edit', compact('queue', 'patients', 'polis', 'dokters'));
    }

    public function update(Request $request, Queue $queue)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'poli_id' => 'required|exists:polis,id',
            'dokter_id' => 'nullable|exists:dokters,id',
            'priority' => 'required|in:ringan,sedang,berat',
            'appointment_time' => 'nullable|date_format:H:i',
            'complaint' => 'nullable|string|max:1000',
            'keterangan' => 'nullable|string|max:500',
            'status' => 'required|in:waiting,called,skipped,completed'
        ]);

        try {
            DB::beginTransaction();

            // Jika poli berubah, perlu update kuota
            if ($queue->poli_id != $request->poli_id) {
                // Kurangi kuota poli lama
                $oldPoliQuota = PoliQuota::where('poli_id', $queue->poli_id)
                    ->where('quota_date', $queue->checkup_date->format('Y-m-d'))
                    ->first();
                if ($oldPoliQuota && $oldPoliQuota->current_count > 0) {
                    $oldPoliQuota->decrement('current_count');
                }

                // Cek kuota poli baru
                $newPoliQuota = $this->checkAndUpdatePoliQuota($request->poli_id, $queue->checkup_date);
                if (!$newPoliQuota) {
                    return back()->with('error', 'Kuota untuk poli baru sudah penuh!');
                }
                $newPoliQuota->increment('current_count');
            }

            $queue->update($request->except(['checkup_date'])); // checkup_date tidak bisa diubah

            DB::commit();

            return redirect()->route('staff.queues.index')
                ->with('success', 'Antrian berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Queue $queue)
    {
        try {
            DB::beginTransaction();

            // Kurangi current_count di poli_quotas
            $poliQuota = PoliQuota::where('poli_id', $queue->poli_id)
                ->where('quota_date', $queue->checkup_date->format('Y-m-d'))
                ->first();

            if ($poliQuota && $poliQuota->current_count > 0) {
                $poliQuota->decrement('current_count');
            }

            $queue->delete();

            DB::commit();

            return redirect()->route('staff.queues.index')
                ->with('success', 'Antrian berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function call(Queue $queue)
    {
        try {
            DB::beginTransaction();

            $queue->update([
                'status' => 'called',
                'called_time' => Carbon::now()->format('H:i:s')
            ]);

            // Simpan riwayat panggilan
            CallHistory::create([
                'queue_id' => $queue->id,
                'called_time' => Carbon::now(),
                'status' => 'called'
            ]);

            DB::commit();

            return back()->with('success', "Pasien {$queue->patient->nama} berhasil dipanggil");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function complete(Queue $queue)
    {
        $queue->update(['status' => 'completed']);

        return back()->with('success', "Antrian {$queue->queue_number} telah selesai");
    }

    public function skip(Queue $queue)
    {
        $queue->update(['status' => 'skipped']);

        return back()->with('success', "Antrian {$queue->queue_number} telah dilewati");
    }

    public function printQueue(Queue $queue)
    {
        $queue->load(['patient', 'poli', 'dokter']);

        return view('staff.queues.print', compact('queue'));
    }

    public function review(Queue $queue)
    {
        $queue->load(['patient', 'poli', 'dokter', 'callHistories']);

        return view('staff.queues.review', compact('queue'));
    }

    public function history()
    {
        $queues = Queue::with(['patient', 'poli', 'dokter'])
            ->whereDate('checkup_date', '<', Carbon::today())
            ->orderBy('checkup_date', 'desc')
            ->orderBy('queue_number')
            ->paginate(20);

        return view('staff.queues.history', compact('queues'));
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
