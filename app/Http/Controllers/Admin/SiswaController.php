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
     * Tampilkan daftar siswa PKL.
     */
    public function index()
    {
        $siswas = User::where('role', 'siswa')->latest()->get();
        return view('admin.siswa.index', compact('siswas'));
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
        // 🟢 HAPUS VALIDASI PASSWORD DI DIEU
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
            'password' => Hash::make('password123'), // 🔑 Password otomatis
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

        // Ambil data inputan
        $data = $request->only([
            'name', 'email', 'asal_sekolah', 'departemen_lpkia', 
            'tanggal_mulai_pkl', 'tanggal_selesai_pkl',
            'nisn', 'no_hp', 'nama_orang_tua', 'alamat'
        ]);

        // Update password jika diisi oleh admin
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        // Simpen ka database
        $siswa->update($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Data & biodata siswa berhasil diperbarui!');
    }

    // 🟢 FUNGSI EXPORT PDF
    public function exportPdf()
    {
        $siswas = User::where('role', 'siswa')->get();
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