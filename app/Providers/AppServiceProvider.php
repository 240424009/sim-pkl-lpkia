<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\JurnalKegiatan;
use App\Models\Perizinan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $pendingJurnal = 0;
            $pendingPerizinan = 0;

            if (auth()->check() && auth()->user()->role === 'admin') {
                // Hitung jurnal jika tabel dan kolomnya cocok
                if (class_exists(JurnalKegiatan::class)) {
                    $query = JurnalKegiatan::query();
                    $table = (new JurnalKegiatan)->getTable();

                    if (Schema::hasColumn($table, 'status')) {
                        $pendingJurnal = $query->where('status', 'Pending')->count();
                    } elseif (Schema::hasColumn($table, 'status_verifikasi')) {
                        $pendingJurnal = $query->where('status_verifikasi', 'Pending')->count();
                    } else {
                        // Jika tidak ada kolom status/verifikasi, tampilkan total jurnal yang belum di-validasi
                        $pendingJurnal = $query->count(); 
                    }
                }

                // Hitung perizinan
                if (class_exists(Perizinan::class)) {
                    $pendingPerizinan = Perizinan::where('status', 'Pending')->count();
                }
            }

            $view->with([
                'pendingJurnalCount' => $pendingJurnal,
                'pendingPerizinanCount' => $pendingPerizinan,
            ]);
        });
    }
}