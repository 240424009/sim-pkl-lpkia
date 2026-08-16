<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JamKerja;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $today = Carbon::now()->format('Y-m-d');
        
        // Cek presensi hari ini
        $presensiHariIni = Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        // Pemetaan Hari Inggris -> Indonesia/Sunda
        $mapHari = [
            'Sunday' => 'minggu',
            'Monday' => 'senin',
            'Tuesday' => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday' => 'kamis',
            'Friday' => 'jumat',
            'Saturday' => 'sabtu',
        ];

        $namaHariInggris = Carbon::now()->format('l');
        $namaHari = $mapHari[$namaHariInggris] ?? 'senin';

        // Ambil aturan jam kerja berdasarkan hari ini
        $jamKerja = JamKerja::where('hari', $namaHari)->first();

        // Ambil riwayat presensi siswa
        $riwayatPresensi = Presensi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('siswa.presensi.index', compact('presensiHariIni', 'jamKerja', 'riwayatPresensi'));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $jamSekarang = $now->format('H:i:s');

        $mapHari = [
            'Sunday' => 'minggu',
            'Monday' => 'senin',
            'Tuesday' => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday' => 'kamis',
            'Friday' => 'jumat',
            'Saturday' => 'sabtu',
        ];

        $namaHariInggris = $now->format('l');
        $namaHari = $mapHari[$namaHariInggris] ?? 'senin';

        // Cek aturan jam kerja
        $jamKerja = JamKerja::where('hari', $namaHari)->first();

        if (!$jamKerja) {
            return redirect()->back()->with('error', 'Hari ini tidak ada jadwal jam kerja PKL.');
        }

        // Cek apakah sudah presensi masuk
        $presensi = Presensi::where('user_id', $userId)->where('tanggal', $today)->first();

        if ($request->tipe === 'masuk') {
            if ($presensi) {
                return redirect()->back()->with('error', 'Anda sudah melakukan presensi masuk hari ini.');
            }

            // Hitung keterlambatan (Jam Masuk + Toleransi)
            $jamBatasToleransi = Carbon::parse($jamKerja->jam_masuk)->addMinutes($jamKerja->toleransi_menit)->format('H:i:s');
            $status = ($jamSekarang > $jamBatasToleransi) ? 'terlambat' : 'hadir';

            Presensi::create([
                'user_id' => $userId,
                'tanggal' => $today,
                'jam_masuk' => $jamSekarang,
                'status' => $status,
                'status_approval' => 'approved',
            ]);

            return redirect()->back()->with('success', 'Presensi masuk berhasil dicatat!');
        } 
        
        if ($request->tipe === 'pulang') {
            if (!$presensi) {
                return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk hari ini.');
            }

            if ($presensi->jam_pulang !== null) {
                return redirect()->back()->with('error', 'Anda sudah melakukan presensi pulang hari ini.');
            }

            $presensi->update([
                'jam_pulang' => $jamSekarang,
            ]);

            return redirect()->back()->with('success', 'Presensi pulang berhasil dicatat!');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }
}