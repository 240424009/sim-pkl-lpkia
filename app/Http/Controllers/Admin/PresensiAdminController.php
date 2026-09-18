<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class PresensiAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Presensi::with('user');

        // Filter dumasar Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter dumasar Sekolah Asal (ngalewatan relasi user)
        if ($request->filled('sekolah')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('asal_sekolah', $request->sekolah);
            });
        }

        // Urutkeun ti data pang-enggalna
        $presensi = $query->latest('tanggal')->latest('created_at')->paginate(15);

        // Ambil daftar sekolah unik kanggo pilihan dropdown filter
        $sekolahs = User::where('role', 'siswa')
            ->whereNotNull('asal_sekolah')
            ->distinct()
            ->pluck('asal_sekolah');

        return view('admin.presensi.index', compact('presensi', 'sekolahs'));
    }

    /**
     * Nampilkeun Form Input Presensi Manual
     */
    public function createManual()
    {
        $siswas = User::where('role', 'siswa')->orderBy('name', 'asc')->get();
        return view('admin.presensi.create_manual', compact('siswas'));
    }

    /**
     * Nyimpen Data Presensi Manual (Jam Masuk + Jam Pulang)
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'tanggal'    => 'required|date',
            'jam_masuk'  => 'required',
            'jam_pulang' => 'nullable', // Jam pulang bersifat opsional
            'status'     => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            // Update pami tos aya data dina tanggal anu sami, atanapi create anyar
            Presensi::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'jam_masuk'  => $request->jam_masuk,
                    'jam_pulang' => $request->jam_pulang, // Nyaipkeun jam pulang
                    'status'     => strtolower($request->status),
                    'keterangan' => $request->keterangan,
                ]
            );

            return redirect()->back()->with('success', 'Presensi manual berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan presensi: ' . $e->getMessage());
        }
    }
}