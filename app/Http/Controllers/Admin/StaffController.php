<?php
// app/Http/Controllers/Admin/StaffController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        // Ambil semua staff dengan role 'staff'
        $staffs = User::role('staff')->get();
        return view('admin.staff.index', compact('staffs'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role 'staff' ke user
        $staffRole = Role::findByName('staff');
        $user->assignRole($staffRole);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff berhasil ditambahkan.');
    }

    public function edit(User $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data staff
        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $staff->password,
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff berhasil diperbarui.');
    }

    public function destroy(User $staff)
    {
        // Hapus data staff
        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff berhasil dihapus.');
    }
}
