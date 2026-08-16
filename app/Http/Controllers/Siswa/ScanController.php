<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScanController extends Controller
{
    // Tampilan Kamera Scanner
    public function index()
    {
        return view('siswa.scan_qr');
    }

    // Proses Hasil Scan QR
    public function store(Request $request)
    {
        $qrCodeData = $request->qr_code;
        $today = Carbon::today()->toDateString();
        $expectedQr = 'PRESENSI_LPKIA_' . $today;

        // Validasi eusi QR Code
        if ($qrCodeData !== $expectedQr) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kadaluarsa!'
            ], 400);
        }

        $userId = auth()->id();
        $now = Carbon::now();
        $jamMasukBatas = Carbon::createFromTimeString('08:00:00');

        // Cek naha geus presensi poé ieu
        $presensi = Presensi::where('user_id', $userId)->where('tanggal', $today)->first();

        if (!$presensi) {
            // Presensi Masuk
            $status = $now->greaterThan($jamMasukBatas) ? 'terlambat' : 'hadir';

            Presensi::create([
                'user_id' => $userId,
                'tanggal' => $today,
                'jam_masuk' => $now->toTimeString(),
                'status' => $status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi MASUK berhasil! Status: ' . strtoupper($status)
            ]);
        } else {
            // Presensi Pulang
            if ($presensi->jam_pulang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan presensi masuk & pulang hari ini!'
                ], 400);
            }

            $presensi->update([
                'jam_pulang' => $now->toTimeString(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Presensi PULANG berhasil Recorded!'
            ]);
        }
    }
}