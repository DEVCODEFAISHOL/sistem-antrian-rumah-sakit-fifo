<?php
// app/Http/Controllers/Admin/PatientController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            Session::flash('info', 'Belum ada data pasien.');
        }

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

   public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:patients,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'medical_history' => 'nullable|string',
        ]);

         try {
           $patient = Patient::create($validatedData);
             Session::flash('success', 'Pasien berhasil ditambahkan.');
              return redirect()->route('admin.patients.index');
         } catch (\Exception $e) {
              Session::flash('error', 'Terjadi kesalahan saat menambahkan pasien. ' . $e->getMessage());
             return redirect()->back()->withInput();
          }

    }

    public function show(Patient $patient)
     {
         $patient->load('queues.poli','queues.dokter');
        return view('admin.patients.show', compact('patient'));
    }


    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:patients,nik,' . $patient->id,
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'medical_history' => 'nullable|string',
        ]);

         try {
             $patient->update($validatedData);
            Session::flash('success', 'Pasien berhasil diperbarui.');
            return redirect()->route('admin.patients.index');
         } catch (\Exception $e) {
              Session::flash('error', 'Terjadi kesalahan saat memperbarui pasien. '. $e->getMessage());
             return redirect()->back()->withInput();
        }
    }

    public function destroy(Patient $patient)
    {
          try {
             $patient->delete();
             Session::flash('success', 'Pasien berhasil dihapus.');
            return redirect()->route('admin.patients.index');
           } catch (\Exception $e) {
              Session::flash('error', 'Terjadi kesalahan saat menghapus pasien. ' . $e->getMessage());
             return redirect()->back();
         }
    }


     public function history()
    {
        $queues = Queue::with(['patient','poli', 'dokter'])
             ->orderBy('created_at', 'desc')
            ->get();
          return view('admin.patients.history', compact('queues'));
    }
}
