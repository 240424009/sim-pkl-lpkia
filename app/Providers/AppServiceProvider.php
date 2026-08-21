<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
                // Hitung jurnal nu can diverifikasi (status_approval nya null atawa pending)
                if (class_exists(JurnalKegiatan::class)) {
                    $pendingJurnal = JurnalKegiatan::whereNull('status_approval')
                        ->orWhere('status_approval', 'pending')
                        ->orWhere('status_approval', 'Pending')
                        ->count();
                }

                // Hitung perizinan nu can diverifikasi
                if (class_exists(Perizinan::class)) {
                    $pendingPerizinan = Perizinan::whereNull('status')
                        ->orWhere('status', 'pending')
                        ->orWhere('status', 'Pending')
                        ->count();
                }
            }

            $view->with([
                'pendingJurnalCount' => $pendingJurnal,
                'pendingPerizinanCount' => $pendingPerizinan,
            ]);
        });
    }
}