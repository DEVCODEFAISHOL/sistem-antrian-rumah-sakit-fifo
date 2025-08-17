<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallHistory;
use App\Models\Poli; // Tambahkan ini
use App\Models\Queue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();

        // Ambil kuota harian dari poli (contoh: Penyakit Dalam dengan kode 'PE')
        // Pastikan Anda memiliki model Poli dengan kolom 'kode_poli' dan 'kapasitas_harian'
        $poli = Poli::where('kode_poli', 'PE')->first();
        $dailyQuota = $poli ? $poli->kapasitas_harian : 20; // Fallback kuota 20 jika tidak ditemukan

        // Hitung total antrian hari ini berdasarkan tanggal periksa (checkup_date)
        $totalQueuesToday = Queue::whereDate('checkup_date', $today)->count();

        // Hitung sisa kuota
        $remainingQuota = $dailyQuota - $totalQueuesToday;

        // Hitung total antrian yang sudah dipanggil hari ini
        $totalCalledQueues = Queue::whereDate('checkup_date', $today)
            ->whereIn('status', ['called', 'completed', 'skipped']) // Status yang dianggap sudah lewat
            ->count();

        // Ambil antrian terakhir yang dipanggil hari ini
        $lastQueue = Queue::whereDate('checkup_date', $today)
            ->where('status', 'called')
            ->orderBy('called_time', 'desc')
            ->first();

        // Ambil antrian selanjutnya (antrian pertama yang masih waiting) hari ini, urutkan berdasarkan nomor antrian
        $nextQueue = Queue::whereDate('checkup_date', $today)
            ->where('status', 'waiting')
            ->orderBy('queue_number', 'asc')
            ->first();

        // Ambil antrian saat ini (seluruh prioritas) hari ini
        // Variabel ini memiliki logika yang sama dengan $nextQueue, Anda bisa menggunakan salah satunya
        $currentQueue = $nextQueue;


        // Ambil antrian saat ini (ringan - sedang) hari ini
        $currentQueueLightMedium = Queue::whereDate('checkup_date', $today)
            ->where('status', 'waiting')
            ->whereIn('priority', ['ringan', 'sedang'])
            ->orderBy('queue_number', 'asc')
            ->first();

        // Ambil antrian saat ini (berat) hari ini
        $currentQueueHeavy = Queue::whereDate('checkup_date', $today)
            ->where('status', 'waiting')
            ->where('priority', 'berat')
            ->orderBy('queue_number', 'asc')
            ->first();


        // Ambil daftar antrian hari ini untuk ditampilkan di tabel, urutkan berdasarkan nomor antrian
        $queues = Queue::with('patient')
            ->whereDate('checkup_date', $today)
            ->orderBy('queue_number', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalQueuesToday',
            'totalCalledQueues',
            'lastQueue',
            'nextQueue',
            'currentQueue',
            'currentQueueLightMedium',
            'currentQueueHeavy',
            'queues',
            'dailyQuota',      // Kirim data kuota harian ke view
            'remainingQuota'   // Kirim data sisa kuota ke view
        ));
    }

    public function callQueue(Queue $queue)
    {
        // Perbarui status antrian menjadi "called" dan waktu dipanggil
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

    public function visitsReport()
    {
        // Saran: Ubah juga 'created_at' menjadi 'checkup_date' jika laporan ingin sesuai tanggal periksa
        $visitsByDate = Queue::select(DB::raw('DATE(checkup_date) as visit_date'), DB::raw('count(*) as total_visits'))
            ->groupBy('visit_date')
            ->orderBy('visit_date', 'asc')
            ->get();
        return view('admin.reports.visits', compact('visitsByDate'));
    }


    public function waitingTimeReport()
    {
        // Saran: Ubah juga 'created_at' menjadi 'checkup_date' jika laporan ingin sesuai tanggal periksa
        $queues = Queue::whereNotNull('called_time')->whereNotNull('appointment_time')
            ->whereDate('checkup_date', today())
            ->get()
            ->map(function ($queue) {
                $appointment = Carbon::parse($queue->appointment_time);
                $called = Carbon::parse($queue->called_time);
                $waitingTime = $called->diffInMinutes($appointment);
                return [
                    'queue_number' => $queue->queue_number,
                    'patient_name' => $queue->patient->name,
                    'appointment_time' => $appointment->format('H:i'),
                    'called_time' => $called->format('H:i'),
                    'waiting_time' => $waitingTime,
                ];
            });

        return view('admin.reports.waiting-time', compact('queues'));
    }
}
