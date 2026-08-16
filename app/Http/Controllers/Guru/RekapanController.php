<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Presensi;
use App\Models\JurnalKegiatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapanController extends Controller
{
    // Rekapan Presensi Siswa
    public function presensi()
    {
        // Ambil semua siswa beserta data presensinya
        $siswas = User::where('role', 'siswa')
            ->with(['presensis'])
            ->get();

        return view('guru.presensi.index', compact('siswas'));
    }

    // Monitoring Jurnal Siswa
    public function jurnal()
    {
        // Ambil semua jurnal siswa
        $jurnals = JurnalKegiatan::with('user')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        return view('guru.jurnal.index', compact('jurnals'));
    }

    // === FUNGSI EXPORT PDF ===
    public function exportPresensiPdf()
    {
        $siswas = User::where('role', 'siswa')->with(['presensis'])->get();
        
        // Load view khusus PDF
        $pdf = Pdf::loadView('guru.presensi.pdf', compact('siswas'));
        
        // Download file
        return $pdf->download('Rekapan_Presensi_Siswa_PKL.pdf');
    }
}