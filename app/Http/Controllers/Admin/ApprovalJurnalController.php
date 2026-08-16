<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalKegiatan;
use Illuminate\Http\Request;

class ApprovalJurnalController extends Controller
{
    public function index()
    {
        // Ambil semua jurnal beserta data siswa
        $jurnals = JurnalKegiatan::with('user')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        return view('admin.jurnal.index', compact('jurnals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_approval' => 'required|in:approved,rejected',
            'rating' => 'nullable|integer|min:1|max:5',
            'catatan_pembimbing' => 'nullable|string',
        ]);

        $jurnal = JurnalKegiatan::findOrFail($id);
        $jurnal->update([
            'status_approval' => $request->status_approval,
            'rating' => $request->rating,
            'catatan_pembimbing' => $request->catatan_pembimbing,
        ]);

        return redirect()->back()->with('success', 'Status dan penilaian jurnal berhasil diperbarui!');
    }
}