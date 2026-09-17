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
    // Rekapan Presensi Siswa (kalawan Filter Asal Sekolah)
    public function presensi(Request $request)
    {
        // 1. Ambil daftar sekolah unik untuk dropdown filter
        $sekolahs = User::where('role', 'siswa')
            ->whereNotNull('asal_sekolah')
            ->distinct()
            ->pluck('asal_sekolah');

        // 2. Query data siswa
        $query = User::where('role', 'siswa')->with(['presensis']);

        // 3. Filter jika dropdown sekolah dipilih
        if ($request->filled('sekolah')) {
            $query->where('asal_sekolah', $request->sekolah);
        }

        $siswas = $query->get();

        return view('guru.presensi.index', compact('siswas', 'sekolahs'));
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

    // === FUNGSI EXPORT PDF (NGAIKUTAN FILTER SEKOLAH) ===
    public function exportPresensiPdf(Request $request)
    {
        $query = User::where('role', 'siswa')->with(['presensis']);

        // Jika sedang memfilter sekolah, PDF yang didownload hanya sekolah tersebut
        if ($request->filled('sekolah')) {
            $query->where('asal_sekolah', $request->sekolah);
        }

        $siswas = $query->get();
        $sekolahFilter = $request->sekolah ?? 'Semua Sekolah';

        // Load view khusus PDF
        $pdf = Pdf::loadView('guru.presensi.pdf', compact('siswas', 'sekolahFilter'));

        // Nama file PDF menyesuaikan filter
        $namaFile = $request->filled('sekolah') 
            ? 'Rekapan_Presensi_' . str_replace(' ', '_', $request->sekolah) . '.pdf' 
            : 'Rekapan_Presensi_Semua_Siswa.pdf';

        return $pdf->download($namaFile);
    }
}