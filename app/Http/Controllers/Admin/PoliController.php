<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PoliController extends Controller
{
    /**
     * Menampilkan daftar poli dengan informasi dokter.
     */
    public function index()
    {
        $polis = Poli::with('dokter')->get(); // Load data dokter terkait
        return view('admin.polis.index', compact('polis'));
    }

    /**
     * Menampilkan form untuk membuat poli baru.
     */
    public function create()
    {
        $dokters = Dokter::all();
        return view('admin.polis.create', compact('dokters'));
    }

    /**
     * Menyimpan poli baru ke database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode_poli' => 'required|string|max:50|unique:polis,kode_poli',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas_harian' => 'required|integer|min:1',
            'dokter_id' => 'nullable|exists:dokters,id', // Validasi keberadaan dokter
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            Poli::create($request->all());
            DB::commit();
            return redirect()->route('admin.polis.index')->with('success', 'Poli berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan poli. Silakan coba lagi.' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail poli.
     */
    public function show(Poli $poli)
    {
        $poli->load('dokter');
        return view('admin.polis.show', compact('poli'));
    }

    /**
     * Menampilkan form untuk mengedit poli.
     */
    public function edit(Poli $poli)
    {
        $dokters = Dokter::all();
        return view('admin.polis.edit', compact('poli', 'dokters'));
    }

    /**
     * Mengupdate poli di database.
     */
    public function update(Request $request, Poli $poli)
    {
        $validator = Validator::make($request->all(), [
             'nama' => 'required|string|max:255',
            'kode_poli' => 'required|string|max:50|unique:polis,kode_poli,' . $poli->id,
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas_harian' => 'required|integer|min:1',
            'dokter_id' => 'nullable|exists:dokters,id', // Validasi keberadaan dokter
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

         try {
            DB::beginTransaction();
            $poli->update($request->all());
            DB::commit();
             return redirect()->route('admin.polis.index')->with('success', 'Poli berhasil diperbarui.');
        } catch (\Exception $e) {
             DB::rollBack();
           return redirect()->back()->with('error', 'Gagal memperbarui poli. Silakan coba lagi.' . $e->getMessage())->withInput();
        }
    }


    /**
     * Menghapus poli dari database.
     */
    public function destroy(Poli $poli)
    {
        try {
            DB::beginTransaction();
            $poli->delete();
            DB::commit();
           return redirect()->route('admin.polis.index')->with('success', 'Poli berhasil dihapus.');
        } catch (\Exception $e) {
             DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus poli. Silakan coba lagi.' . $e->getMessage());
        }
    }
}
