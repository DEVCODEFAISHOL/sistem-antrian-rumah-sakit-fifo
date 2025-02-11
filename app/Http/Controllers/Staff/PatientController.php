<?php

namespace App\Http\Controllers\Staff;

use App\Models\Queue;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('staff.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('staff.patients.create');
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

       $patient =  Patient::create($validatedData);

        if ($patient) {
          Session::flash('success', 'Pasien berhasil ditambahkan.');
            return redirect()->route('staff.patients.index');
        } else {
            Session::flash('error', 'Terjadi kesalahan saat menambahkan pasien.');
             return redirect()->back()->withInput();
       }

    }

     public function show(Patient $patient)
    {
        return view('staff.patients.show', compact('patient'));
    }


    public function edit(Patient $patient)
    {
        return view('staff.patients.edit', compact('patient'));
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

       $updated = $patient->update($validatedData);

        if ($updated) {
            Session::flash('success', 'Pasien berhasil diperbarui.');
       } else {
          Session::flash('error', 'Terjadi kesalahan saat memperbarui pasien.');
        }

       return redirect()->route('staff.patients.index');
    }

   public function destroy(Patient $patient)
   {
        $deleted = $patient->delete();

        if ($deleted) {
            Session::flash('success', 'Pasien berhasil dihapus.');
        } else {
           Session::flash('error', 'Terjadi kesalahan saat menghapus pasien.');
        }

       return redirect()->route('staff.patients.index');
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $patients = Patient::where('nama', 'like', "%$search%")
             ->orWhere('nik', 'like', "%$search%")
            ->get();

        return view('staff.patients.index', compact('patients'));
    }

    public function history(Patient $patient) // Requires a Patient object
    {
        $queues = Queue::with(['patient', 'poli', 'dokter'])
            ->where('patient_id', $patient->id) // Filter by patient ID
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.patients.history', compact('queues', 'patient')); // Pass both queues and patient
    }
}
