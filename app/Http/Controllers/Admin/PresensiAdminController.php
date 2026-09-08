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

        // Filter dumasar Nama Siswa
        if ($request->filled('siswa_id')) {
            $query->where('user_id', $request->siswa_id);
        }

        // Urutkeun ti data pang-enggalna
        $presensi = $query->latest('tanggal')->latest('created_at')->paginate(15);

        // Ambil sadaya data siswa kanggo pilihan dropdown filter
        $listSiswa = User::where('role', 'siswa')->orderBy('name', 'asc')->get();

        return view('admin.presensi.index', compact('presensi', 'listSiswa'));
    }
}