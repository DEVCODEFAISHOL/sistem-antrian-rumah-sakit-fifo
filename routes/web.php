<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Staff\QueueController as StaffQueueController;
use App\Http\Controllers\Staff\PatientController as StaffPatientController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route untuk halaman welcome (tidak memerlukan login)
Route::get('/', function () {
    return view('auth/login');
});

// Route untuk pasien (tanpa login)
Route::prefix('patient')->name('patient.')->group(function () {
    // Cek antrian
    Route::get('/check-queue', [QueueController::class, 'checkQueue'])->name('check-queue');
    // Lihat antrian berikutnya
    Route::get('/next-queue', [QueueController::class, 'nextQueue'])->name('next-queue');
});

// Group route yang memerlukan login
Route::middleware('auth')->group(function () {
    // Route untuk profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Group route untuk admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Kelola dokter
        // Kelola antrian
        Route::resource('queues', QueueController::class);
        Route::post('/queues/{queue}/call', [QueueController::class, 'callQueue'])->name('queues.call');
        Route::post('/queues/call-next', [QueueController::class, 'callNextQueue'])->name('queues.call-next'); // Method terpisah
        Route::post('/queues/{queue}/complete', [QueueController::class, 'completeQueue'])->name('queues.complete');
        Route::post('/queues/{queue}/skip', [QueueController::class, 'skipQueue'])->name('queues.skip');

        // Konfigurasi sistem antrian
        Route::get('/queues/config', [QueueController::class, 'config'])->name('queues.config');
        Route::post('/queues/config', [QueueController::class, 'updateConfig'])->name('queues.update-config');

        Route::resource('dokters', DokterController::class);
        // Kelola poli
        Route::resource('polis', PoliController::class);
        // Kelola staff
        Route::resource('staff', StaffController::class);
        Route::post('/staff/{staff}/reset-password', [StaffController::class, 'resetPassword'])->name('staff.reset-password');

        // Kelola pasien
        Route::get('/patients/history', [PatientController::class, 'history'])->name('patients.history');
        Route::resource('patients', PatientController::class);
        Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
        // Monitoring & Reporting
        Route::get('/reports/visits', [DashboardController::class, 'visitsReport'])->name('reports.visits');
        Route::get('/reports/waiting-time', [DashboardController::class, 'waitingTimeReport'])->name('reports.waiting-time');
    });

    // 3c. Group route untuk staff
    Route::middleware(['role:staff'])->prefix('staff')->name('staff.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

        // Kelola antrian
        Route::resource('queues', StaffQueueController::class);
        Route::post('/queues/{queue}/call', [StaffQueueController::class, 'call'])->name('queues.call');
        Route::post('/queues/{queue}/complete', [StaffQueueController::class, 'complete'])->name('queues.complete');
        Route::post('/queues/{queue}/skip', [StaffQueueController::class, 'skip'])->name('queues.skip');
        // Kelola antrian hari ini dan sebelumnya

        Route::get('/queues/history', [StaffQueueController::class, 'history'])->name('queues.history');
        Route::get('/queues/{queue}/print', [StaffQueueController::class, 'printQueue'])->name('queues.print');
        Route::get('/queues/{queue}/preview', [StaffQueueController::class, 'review'])->name('queues.preview');

        // Kelola pasien
        Route::resource('patients', StaffPatientController::class);
       Route::get('/patients/history', [StaffPatientController::class, 'history'])->name('patients.history');
    });
});

// Route untuk autentikasi (login, register, dll.)
require __DIR__ . '/auth.php';
