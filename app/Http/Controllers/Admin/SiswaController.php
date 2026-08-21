<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa PKL dengan Filter Rentang Bulan.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        $bulanMulai = $request->bulan_mulai;
        $bulanSelesai = $request->bulan_selesai;
        $tahunSelected = $request->tahun ?? date('Y');

        if ($request->filled('bulan_mulai') && $request->filled('bulan_selesai')) {
            $bMulai = sprintf('%02d', $request->bulan_mulai);
            $bSelesai = sprintf('%02d', $request->bulan_selesai);
            
            $startDate = "$tahunSelected-$bMulai-01";
            $endDate = date('Y-m-t', strtotime("$tahunSelected-$bSelesai-01"));

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_mulai_pkl', [$startDate, $endDate])
                  ->orWhereBetween('tanggal_selesai_pkl', [$startDate, $endDate])
                  ->orWhere(function ($sub) use ($startDate, $endDate) {
                      $sub->where('tanggal_mulai_pkl', '<=', $startDate)
                          ->where('tanggal_selesai_pkl', '>=', $endDate);
                  });
            });
        } elseif ($request->filled('tahun')) {
            $query->where(function ($q) use ($tahunSelected) {
                $q->whereYear('tanggal_mulai_pkl', $tahunSelected)
                  ->orWhereYear('tanggal_selesai_pkl', $tahunSelected);
            });
        }

        $siswas = $query->latest()->get();

        return view('admin.siswa.index', compact('siswas', 'bulanMulai', 'bulanSelesai', 'tahunSelected'));
    }

    /**
     * Form tambah siswa PKL baru.
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan data siswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'asal_sekolah' => 'nullable|string|max:255',
            'departemen_lpkia' => 'nullable|string|max:255',
            'tanggal_mulai_pkl' => 'nullable|date',
            'tanggal_selesai_pkl' => 'nullable|date',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'asal_sekolah' => $request->asal_sekolah,
            'departemen_lpkia' => $request->departemen_lpkia,
            'tanggal_mulai_pkl' => $request->tanggal_mulai_pkl,
            'tanggal_selesai_pkl' => $request->tanggal_selesai_pkl,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa PKL berhasil ditambahkan!');
    }

    /**
     * Form edit & detail biodata siswa PKL.
     */
    public function edit($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update data penempatan & biodata lengkap siswa.
     */
    public function update(Request $request, $id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'asal_sekolah' => 'nullable|string|max:255',
            'departemen_lpkia' => 'nullable|string|max:255',
            'tanggal_mulai_pkl' => 'nullable|date',
            'tanggal_selesai_pkl' => 'nullable|date',
            'nisn' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:20',
            'nama_orang_tua' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $data = $request->only([
            'name', 'email', 'asal_sekolah', 'departemen_lpkia', 
            'tanggal_mulai_pkl', 'tanggal_selesai_pkl',
            'nisn', 'no_hp', 'nama_orang_tua', 'alamat'
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Data & biodata siswa berhasil diperbarui!');
    }

    // 🟢 FUNGSI EXPORT PDF
    public function exportPdf(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->filled('bulan_mulai') && $request->filled('bulan_selesai')) {
            $bMulai = sprintf('%02d', $request->bulan_mulai);
            $bSelesai = sprintf('%02d', $request->bulan_selesai);
            $tahun = $request->tahun ?? date('Y');
            
            $startDate = "$tahun-$bMulai-01";
            $endDate = date('Y-m-t', strtotime("$tahun-$bSelesai-01"));

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_mulai_pkl', [$startDate, $endDate])
                  ->orWhereBetween('tanggal_selesai_pkl', [$startDate, $endDate])
                  ->orWhere(function ($sub) use ($startDate, $endDate) {
                      $sub->where('tanggal_mulai_pkl', '<=', $startDate)
                          ->where('tanggal_selesai_pkl', '>=', $endDate);
                  });
            });
        }

        $siswas = $query->get();
        $pdf = Pdf::loadView('admin.siswa.pdf', compact('siswas'))->setPaper('a4', 'landscape');
        return $pdf->download('Rekap_Data_Siswa_PKL_LPKIA.pdf');
    }

    // 🟢 FUNGSI HAPUS SATU SISWA
    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    // 🟢 FUNGSI HAPUS SEMUA SISWA
    public function deleteAll()
    {
        User::where('role', 'siswa')->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Semua data siswa PKL berhasil dibersihkan!');
    }
}