<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use App\Models\Wilayah;

/*
|--------------------------------------------------------------------------|
| Web Routes                                                                |
|--------------------------------------------------------------------------|
|
| Here is where you can register web routes for your application. These   |
| routes are loaded by the RouteServiceProvider and all of them will      |
| be assigned to the "web" middleware group. Make something great!         |
|
*/

Route::get('/', function () {
    return redirect()->route('login'); // Redirect to login page
});

// Routes protected by auth middleware
Route::middleware('auth')->group(function () {

    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::resource('laporan', LaporanController::class);

});

Route::get('laporan/export', [AdminController::class, 'exportLaporan'])->name('laporan.export');
Route::get('laporan/export-pdf', [AdminController::class, 'exportPdf'])->name('laporan.exportPdf');

// Laporan Routes

/// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('wilayah', WilayahController::class);
    Route::resource('laporan', AdminController::class);
 
    

    // Verify laporan
    Route::post('/laporan/{id}/verify', [AdminController::class, 'verify'])->name('laporan.verify');
});

require __DIR__ . '/auth.php';
