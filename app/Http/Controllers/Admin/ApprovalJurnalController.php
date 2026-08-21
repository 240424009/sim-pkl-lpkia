<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalKegiatan;
use Illuminate\Http\Request;

class ApprovalJurnalController extends Controller
{
    public function index(Request $request)
    {
        $query = JurnalKegiatan::with('user');

        // Filter per Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter per Tahun (default taun ayeuna mun teu dipilih)
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        } else {
            $query->whereYear('tanggal', date('Y'));
        }

        $jurnals = $query->orderBy('tanggal', 'desc')
                         ->paginate(15)
                         ->withQueryString(); // Ngaluluzkeun parameter filter pas berpindah halaman pagination

        $bulanSelected = $request->bulan;
        $tahunSelected = $request->tahun ?? date('Y');

        return view('admin.jurnal.index', compact('jurnals', 'bulanSelected', 'tahunSelected'));
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