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
    // Rekapan Presensi Siswa (Filter Sekolah, Bulan & Tahun)
    public function presensi(Request $request)
    {
        // 1. Ambil daftar sekolah unik untuk dropdown filter
        $sekolahs = User::where('role', 'siswa')
            ->whereNotNull('asal_sekolah')
            ->distinct()
            ->pluck('asal_sekolah');

        // 2. Ambil nilai filter bulan & tahun (default: bulan & tahun berjalan)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // 3. Query data siswa beserta presensi yang difilter bulan & tahun
        $query = User::where('role', 'siswa')->with(['presensis' => function ($q) use ($bulan, $tahun) {
            if ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            }
            if ($tahun) {
                $q->whereYear('tanggal', $tahun);
            }
        }]);

        // 4. Filter dumasar sekolah mun dipilih
        if ($request->filled('sekolah')) {
            $query->where('asal_sekolah', $request->sekolah);
        }

        $siswas = $query->get();

        return view('guru.presensi.index', compact('siswas', 'sekolahs', 'bulan', 'tahun'));
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

    // === FUNGSI EXPORT PDF (NGAIKUTAN FILTER SEKOLAH & PERIODE) ===
    public function exportPresensiPdf(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $query = User::where('role', 'siswa')->with(['presensis' => function ($q) use ($bulan, $tahun) {
            if ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            }
            if ($tahun) {
                $q->whereYear('tanggal', $tahun);
            }
        }]);

        if ($request->filled('sekolah')) {
            $query->where('asal_sekolah', $request->sekolah);
        }

        $siswas = $query->get();
        $sekolahFilter = $request->sekolah ?? 'Semua Sekolah';

        // Load view khusus PDF
        $pdf = Pdf::loadView('guru.presensi.pdf', compact('siswas', 'sekolahFilter', 'bulan', 'tahun'));

        // Nama file PDF dinamis menyesuaikan filter
        $strSekolah = $request->filled('sekolah') ? str_replace(' ', '_', $request->sekolah) : 'Semua_Sekolah';
        $namaFile = 'Rekapan_Presensi_' . $strSekolah . '_' . $bulan . '_' . $tahun . '.pdf';

        return $pdf->download($namaFile);
    }
}