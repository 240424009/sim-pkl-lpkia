<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Presensi;
use App\Models\JurnalKegiatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // 1. Total Siswa
        $totalSiswa = User::where('role', 'siswa')->count();

        // 2. Data Presensi Hari Ini
        $presensiHariIni = Presensi::with('user')
            ->whereDate('tanggal', $today)
            ->latest('jam_masuk')
            ->get();

        // 3. Statistik Presensi
        $totalHadir = $presensiHariIni->where('status', 'hadir')->count();
        $totalIzinSakit = $presensiHariIni->whereIn('status', ['izin', 'ijin', 'sakit'])->count();
        $totalAlpha = $presensiHariIni->where('status', 'alpha')->count();

        // 4. Jurnal Harian Terbaru (5 Terakhir)
        $jurnalTerbaru = JurnalKegiatan::with('user')
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'presensiHariIni',
            'totalHadir',
            'totalIzinSakit',
            'totalAlpha',
            'jurnalTerbaru'
        ));
    }
}