<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallHistory;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CallHistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat panggilan.
     */
    public function index()
    {
         $callHistories = CallHistory::with(['queue.patient', 'queue.poli', 'queue.dokter'])
            ->orderBy('called_time', 'desc')
            ->get();
        return view('admin.call-histories.index', compact('callHistories'));
    }

      /**
     * Menampilkan form untuk membuat riwayat panggilan baru.
     */
    public function create()
    {
         $queues = Queue::all();
        return view('admin.call-histories.create', compact('queues'));
    }


    /**
     * Menyimpan riwayat panggilan baru ke database.
     */
    public function store(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'queue_id' => 'required|exists:queues,id',
            'called_time' => 'required|date_format:H:i:s',
             'status' => 'required|in:called,skipped,completed',
        ]);

           if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

          try {
             DB::beginTransaction();
             CallHistory::create($request->all());
            DB::commit();
            return redirect()->route('admin.call-histories.index')
                ->with('success', 'Riwayat panggilan berhasil ditambahkan.');
           } catch (\Exception $e) {
            DB::rollBack();
           return redirect()->back()->with('error', 'Gagal menambahkan riwayat panggilan. Silakan coba lagi.' . $e->getMessage())->withInput();
          }
    }


    /**
     * Menampilkan detail riwayat panggilan.
     */
    public function show(CallHistory $callHistory)
    {
           $callHistory->load(['queue.patient', 'queue.poli','queue.dokter']);
        return view('admin.call-histories.show', compact('callHistory'));
    }

    /**
     * Menampilkan form untuk mengedit riwayat panggilan.
     */
     public function edit(CallHistory $callHistory)
    {
          $queues = Queue::all();
        return view('admin.call-histories.edit', compact('callHistory','queues'));
    }


    /**
     * Mengupdate riwayat panggilan di database.
     */
    public function update(Request $request, CallHistory $callHistory)
    {
          $validator = Validator::make($request->all(), [
            'queue_id' => 'required|exists:queues,id',
            'called_time' => 'required|date_format:H:i:s',
             'status' => 'required|in:called,skipped,completed',
        ]);

           if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

         try {
            DB::beginTransaction();
             $callHistory->update($request->all());
             DB::commit();
            return redirect()->route('admin.call-histories.index')
                ->with('success', 'Riwayat panggilan berhasil diperbarui.');
        } catch (\Exception $e) {
             DB::rollBack();
             return redirect()->back()->with('error', 'Gagal memperbarui riwayat panggilan. Silakan coba lagi.' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus riwayat panggilan.
     */
    public function destroy(CallHistory $callHistory)
    {
        try {
            DB::beginTransaction();
            $callHistory->delete();
            DB::commit();
            return redirect()->route('admin.call-histories.index')->with('success', 'Riwayat panggilan berhasil dihapus.');
         } catch (\Exception $e) {
           DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus riwayat panggilan. Silakan coba lagi.' . $e->getMessage());
         }
    }
}
