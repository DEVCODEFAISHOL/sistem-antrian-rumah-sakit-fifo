<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    /**
     * Menampilkan daftar dokter.
     */
    public function index()
    {
        $dokters = Dokter::all();
        return view('admin.dokters.index', compact('dokters'));
    }

    /**
     * Menampilkan form untuk membuat dokter baru.
     */
    public function create()
    {
        return view('admin.dokters.create');
    }

    /**
     * Menyimpan dokter baru ke database.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'spesialisasi' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

          if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       try {
            DB::beginTransaction();
            Dokter::create($request->all());
            DB::commit();
             return redirect()->route('admin.dokters.index')->with('success', 'Dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
             DB::rollBack();
           return redirect()->back()->with('error', 'Gagal menambahkan dokter. Silakan coba lagi.' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail dokter.
     */
    public function show(Dokter $dokter)
    {
        return view('admin.dokters.show', compact('dokter'));
    }

    /**
     * Menampilkan form untuk mengedit dokter.
     */
    public function edit(Dokter $dokter)
    {
        return view('admin.dokters.edit', compact('dokter'));
    }

    /**
     * Mengupdate dokter di database.
     */
    public function update(Request $request, Dokter $dokter)
    {
          $validator = Validator::make($request->all(), [
           'nama' => 'required|string|max:255',
            'spesialisasi' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $dokter->update($request->all());
            DB::commit();
              return redirect()->route('admin.dokters.index')->with('success', 'Dokter berhasil diperbarui.');
        } catch (\Exception $e) {
              DB::rollBack();
             return redirect()->back()->with('error', 'Gagal memperbarui dokter. Silakan coba lagi.' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus dokter dari database.
     */
    public function destroy(Dokter $dokter)
    {
         try {
            DB::beginTransaction();
            $dokter->delete();
            DB::commit();
            return redirect()->route('admin.dokters.index')->with('success', 'Dokter berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
             return redirect()->back()->with('error', 'Gagal menghapus dokter. Silakan coba lagi.' . $e->getMessage());
        }
    }
}
