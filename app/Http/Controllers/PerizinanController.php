<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerizinanController extends Controller
{
    // ================= SISWA SIDE =================
    
    // Halaman daftar perizinan siswa
    public function indexSiswa()
    {
        $perizinans = Perizinan::where('user_id', Auth::id())->latest()->get();
        return view('siswa.perizinan.index', compact('perizinans'));
    }

    // Form pengajuan izin/sakit
    public function createSiswa()
    {
        return view('siswa.perizinan.create');
    }

    // Simpan pengajuan perizinan
    public function storeSiswa(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:Sakit,Izin,Lainnya',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'bukti_dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('bukti_dokumen')) {
            $filePath = $request->file('bukti_dokumen')->store('bukti_perizinan', 'public');
        }

        Perizinan::create([
            'user_id' => Auth::id(),
            'kategori' => $request->kategori,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'bukti_dokumen' => $filePath,
            'status' => 'Pending',
        ]);

        return redirect()->route('siswa.perizinan.index')->with('success', 'Pengajuan izin berhasil dikirim!');
    }

    // ================= ADMIN / PEMBIMBING SIDE =================

    // Halaman kelola perizinan siswa oleh Admin
    public function indexAdmin(Request $request)
    {
        $query = Perizinan::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perizinans = $query->latest()->get();
        return view('admin.perizinan.index', compact('perizinans'));
    }

    // Update Status Approval (Disetujui / Ditolak)
    public function updateStatusAdmin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $perizinan = Perizinan::findOrFail($id);
        $perizinan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()->with('success', 'Status perizinan berhasil diperbarui!');
    }
}