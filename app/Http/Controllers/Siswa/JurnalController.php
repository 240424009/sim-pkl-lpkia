<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JurnalKegiatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Ambil daftar jurnal kegiatan siswa (diurutkan ti nu panganyarna)
        $jurnals = JurnalKegiatan::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('siswa.jurnal.index', compact('jurnals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi_pekerjaan' => 'required|string|min:10',
        ], [
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'deskripsi_pekerjaan.required' => 'Deskripsi pekerjaan wajib diisi.',
            'deskripsi_pekerjaan.min' => 'Deskripsi pekerjaan minimal 10 karakter.',
        ]);

        $userId = auth()->id();

        // Cek apakah sudah mengisi jurnal di tanggal yang sama
        $cekJurnal = JurnalKegiatan::where('user_id', $userId)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($cekJurnal) {
            return redirect()->back()->with('error', 'Anda sudah mengisi jurnal kegiatan untuk tanggal tersebut.');
        }

        JurnalKegiatan::create([
            'user_id' => $userId,
            'tanggal' => $request->tanggal,
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
            'status_approval' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Jurnal kegiatan berhasil disimpan!');
    }
}