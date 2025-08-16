<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Poli;
use App\Models\PoliQuota;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Ambil kuota dari poli (misal khusus Penyakit Dalam)
        $poli = Poli::where('kode_poli', 'PE')->first();
        $dailyQuota = $poli ? $poli->kapasitas_harian : 20; // fallback 20 jika data kapasitas tidak ditemukan

        // Ambil daftar antrian hari ini berdasarkan checkup_date (bukan created_at)
        $queues = Queue::with('patient')
            ->whereDate('checkup_date', $today)
            ->orderBy('queue_number', 'asc') // Urutkan berdasarkan queue_number
            ->get();

        // Statistik
        $totalQueuesToday = $queues->count();
        $totalCalledQueues = $queues->where('status', 'called')->count();
        $totalCompletedQueues = $queues->where('status', 'completed')->count();
        $totalWaitingQueues = $queues->where('status', 'waiting')->count();
        $totalSkippedQueues = $queues->where('status', 'skipped')->count();

        // Last queue yang dipanggil (berdasarkan called_time terbaru)
        $lastQueue = $queues->where('status', 'called')
            ->whereNotNull('called_time')
            ->sortByDesc('called_time')
            ->first();

        // Next queue untuk dipanggil (prioritas: berat -> sedang -> ringan, berdasarkan queue_number)
        $nextQueue = $queues->where('status', 'waiting')
            ->sortBy([
                ['priority', 'desc'], // Prioritas berat -> sedang -> ringan
                ['queue_number', 'asc'] // Antrian terkecil
            ])
            ->first();

        // Antrian Saat Ini berdasarkan prioritas
        $currentQueue = $queues->where('status', 'waiting')
            ->sortBy('queue_number')
            ->first();

        // Mengambil antrian berdasarkan prioritas ringan atau sedang
        $currentQueueLightMedium = $queues->whereIn('priority', ['ringan', 'sedang'])
            ->where('status', 'waiting')
            ->sortBy('queue_number')
            ->first();

        // Mengambil antrian berdasarkan prioritas berat
        $currentQueueHeavy = $queues->where('priority', 'berat')
            ->where('status', 'waiting')
            ->sortBy('queue_number')
            ->first();

        // Data kuota hari ini dari berbagai poli
        $poliQuotas = PoliQuota::with('poli')
            ->where('quota_date', $today)
            ->get();

        // Statistik tambahan
        $stats = [
            'total' => $totalQueuesToday,
            'waiting' => $totalWaitingQueues,
            'called' => $totalCalledQueues,
            'completed' => $totalCompletedQueues,
            'skipped' => $totalSkippedQueues,
        ];

        // Definisikan statCards untuk pengiriman ke view
        $statCards = [
            ['label' => 'Total Antrian', 'value' => $totalQueuesToday, 'color' => 'sky', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>'],
            ['label' => 'Menunggu', 'value' => $totalWaitingQueues, 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
            ['label' => 'Dipanggil', 'value' => $totalCalledQueues, 'color' => 'yellow', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.636 5.636a9 9 0 0112.728 0M12 18h.01"></path>'],
            ['label' => 'Selesai', 'value' => $totalCompletedQueues, 'color' => 'green', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
            ['label' => 'Dilewati', 'value' => $totalSkippedQueues, 'color' => 'red', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>'],
        ];

        // Return ke view dengan data yang lebih efisien
        return view('staff.dashboard', compact(
            'totalQueuesToday',
            'totalCalledQueues',
            'totalCompletedQueues',
            'totalWaitingQueues',
            'lastQueue',
            'nextQueue',
            'currentQueue',
            'currentQueueLightMedium',
            'currentQueueHeavy',
            'queues',
            'poliQuotas',
            'stats',
            'statCards' // Menyertakan $statCards ke dalam view
        ));
    }
}
