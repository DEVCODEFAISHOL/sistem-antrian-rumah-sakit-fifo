<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();
        // Hitung total antrian hari ini
         $totalQueuesToday = Queue::whereDate('created_at', $today)->count();

        // Hitung total antrian yang sudah dipanggil hari ini
        $totalCalledQueues = Queue::whereDate('created_at', $today)
            ->where('status', 'called')
            ->count();


        // Ambil antrian terakhir yang dipanggil hari ini
         $lastQueue = Queue::whereDate('created_at', $today)
            ->where('status', 'called')
            ->orderBy('called_time', 'desc')
            ->first();


         // Ambil antrian selanjutnya (antrian pertama yang masih waiting) hari ini
         $nextQueue = Queue::whereDate('created_at', $today)
            ->where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->first();


        // Antrian Saat Ini (All, Ringan-Sedang, Berat)
        $currentQueue = Queue::where('status', 'waiting')->whereDate('created_at', today())->orderBy('created_at', 'asc')->first();
       $currentQueueLightMedium = Queue::where('status', 'waiting')->whereIn('priority', ['ringan', 'sedang'])->whereDate('created_at', today())->orderBy('created_at', 'asc')->first();
       $currentQueueHeavy = Queue::where('status', 'waiting')->where('priority', 'berat')->whereDate('created_at', today())->orderBy('created_at', 'asc')->first();

          // Ambil daftar antrian hari ini
         $queues = Queue::with('patient')
           ->whereDate('created_at', today())
           ->orderBy('created_at', 'asc')
           ->get();


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
