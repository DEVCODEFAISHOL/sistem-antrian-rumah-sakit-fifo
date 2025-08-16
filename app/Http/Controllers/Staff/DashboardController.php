<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Poli;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Ambil kuota dari poli (misal khusus Penyakit Dalam)
        $poli = Poli::where('kode_poli', 'PE')->first();
        $dailyQuota = $poli->kapasitas_harian ?? 20; // fallback 20

        // Ambil daftar antrian hari ini (dibatasi kuota harian)
        $queues = Queue::with('patient')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'asc')
            ->limit($dailyQuota) // ⬅️ batasi sesuai kuota
            ->get();

        // Statistik
        $totalQueuesToday = $queues->count();
        $totalCalledQueues = $queues->where('status', 'called')->count();
        $lastQueue = $queues->where('status', 'called')->sortByDesc('called_time')->first();
        $nextQueue = $queues->where('status', 'waiting')->sortBy('created_at')->first();

        // Antrian Saat Ini (All, Ringan-Sedang, Berat) dari queues yang dibatasi
        $currentQueue = $queues->where('status', 'waiting')->first();
        $currentQueueLightMedium = $queues->where('status', 'waiting')
            ->filter(fn($q) => in_array($q->priority, ['ringan', 'sedang']))
            ->first();
        $currentQueueHeavy = $queues->where('status', 'waiting')
            ->where('priority', 'berat')
            ->first();

        return view('staff.dashboard', compact(
            'totalQueuesToday',
            'totalCalledQueues',
            'lastQueue',
            'nextQueue',
            'currentQueue',
            'currentQueueLightMedium',
            'currentQueueHeavy',
            'queues'
        ));
    }
}
