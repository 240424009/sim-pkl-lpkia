<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\PresensiController;
use App\Http\Controllers\PerizinanController;
use App\Models\User;

// Redirect Halaman Utama ka Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Middleware Auth (Kudu Login Hula)
Route::middleware(['auth'])->group(function () {

    // === ROUTE BUKTI PERIZINAN ===
    Route::get('/preview-bukti/{filename}', function ($filename) {
        $path = storage_path('app/public/bukti_perizinan/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->name('preview.bukti');

    // === ROUTE PROFILE (Bawaan Breeze) ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === Logic Redirect Dashboard Utama dumasar kana Role ===
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        } elseif ($role === 'guru') {
            return redirect()->route('guru.dashboard');
        }

        abort(403, 'Role pengguna tidak valid.');
    })->name('dashboard');

    // === ROUTE ADMIN (Pembimbing LPKIA) ===
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // 🟢 DASHBOARD ADMIN (TAMPILKAN TOTAL SISWA PKL)
        Route::get('/dashboard', function () {
            $totalSiswa = User::where('role', 'siswa')->count();
            return view('admin.dashboard', compact('totalSiswa'));
        })->name('dashboard');

        // Tampil QR Code Presensi Harian
        Route::get('/qr-presensi', function () {
            return view('admin.qr_presensi');
        })->name('qr.index');

        // Route Verifikasi Jurnal
        Route::get('/jurnal', [\App\Http\Controllers\Admin\ApprovalJurnalController::class, 'index'])->name('jurnal.index');
        Route::put('/jurnal/{id}', [\App\Http\Controllers\Admin\ApprovalJurnalController::class, 'update'])->name('jurnal.update');

        // 🟢 ROUTE PERIZINAN ADMIN
        Route::get('/perizinan', [PerizinanController::class, 'indexAdmin'])->name('perizinan.index');
        Route::patch('/perizinan/{id}/status', [PerizinanController::class, 'updateStatusAdmin'])->name('perizinan.update-status');

        // 🟢 ROUTE EXPORT PDF & DELETE ALL (Wajib di luhureun resource)
        Route::get('/siswa/export-pdf', [\App\Http\Controllers\Admin\SiswaController::class, 'exportPdf'])->name('siswa.export-pdf');
        Route::delete('/siswa/delete-all', [\App\Http\Controllers\Admin\SiswaController::class, 'deleteAll'])->name('siswa.delete-all');

        // 🟢 ROUTE RESOURCE SISWA (Dipasang sakali wae di handap)
        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class)->except(['show']);
    });

    // === ROUTE SISWA (Anak SMK) ===
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            return view('siswa.dashboard');
        })->name('dashboard');

        // Scan QR Presensi Siswa
        Route::get('/scan', [\App\Http\Controllers\Siswa\ScanController::class, 'index'])->name('scan.index');
        Route::post('/scan', [\App\Http\Controllers\Siswa\ScanController::class, 'store'])->name('scan.store');

        // Presensi Siswa (Manual)
        Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
        Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');

        // Jurnal Siswa
        Route::get('/jurnal', [\App\Http\Controllers\Siswa\JurnalController::class, 'index'])->name('jurnal.index');
        Route::post('/jurnal', [\App\Http\Controllers\Siswa\JurnalController::class, 'store'])->name('jurnal.store');

        // 🟢 ROUTE PERIZINAN SISWA
        Route::get('/perizinan', [PerizinanController::class, 'indexSiswa'])->name('perizinan.index');
        Route::get('/perizinan/create', [PerizinanController::class, 'createSiswa'])->name('perizinan.create');
        Route::post('/perizinan', [PerizinanController::class, 'storeSiswa'])->name('perizinan.store');
    });

    // === ROUTE GURU (Pembimbing Sekolah) ===
    Route::middleware(['role:guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');

        // Monitoring & Rekapan Guru
        Route::get('/presensi', [\App\Http\Controllers\Guru\RekapanController::class, 'presensi'])->name('presensi.index');
        Route::get('/presensi/export-pdf', [\App\Http\Controllers\Guru\RekapanController::class, 'exportPresensiPdf'])->name('presensi.pdf');
        Route::get('/jurnal', [\App\Http\Controllers\Guru\RekapanController::class, 'jurnal'])->name('jurnal.index');
    });

});

require __DIR__.'/auth.php';