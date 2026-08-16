<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Siswa PKL LPKIA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                <!-- HEADER TOMBOL AKSI UTAMA -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-3">
                    <h3 class="text-lg font-bold text-gray-700">Daftar Anak PKL</h3>
                    
                    <div class="flex flex-wrap gap-2">
                        <!-- 📄 TOMBOL EXPORT PDF -->
                        <a href="{{ route('admin.siswa.export-pdf') }}" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-lg shadow transition flex items-center gap-1">
                            📄 Save As PDF
                        </a>

                        <!-- 🗑️ TOMBOL HAPUS SEMUA -->
                        <form action="{{ route('admin.siswa.delete-all') }}" method="POST" onsubmit="return confirm('PERHATIAN! Apakah Anda yakin ingin menghapus SELURUH data siswa PKL? Data tidak bisa dikembalikan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-gray-800 hover:bg-black text-white font-bold text-xs rounded-lg shadow transition">
                                🗑️ Hapus Semua Data
                            </button>
                        </form>

                        <!-- ➕ TOMBOL TAMBAH SISWA -->
                        <a href="{{ route('admin.siswa.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-lg shadow transition">
                            + Tambah Siswa PKL
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b text-gray-700 uppercase text-xs">
                                <th class="p-3">Nama Siswa</th>
                                <th class="p-3">Asal Sekolah</th>
                                <th class="p-3">Departemen LPKIA</th>
                                <th class="p-3">Periode PKL</th>
                                <th class="p-3">Status Biodata</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($siswas as $siswa)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">
                                        <!-- AVATAR & NAMA -->
                                        <div class="flex items-center gap-3">
                                            @if($siswa->foto)
                                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow-sm">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}&background=6366f1&color=ffffff" alt="{{ $siswa->name }}" class="w-10 h-10 rounded-full border border-gray-300 shadow-sm">
                                            @endif
                                            <div>
                                                <div class="font-bold text-gray-800">{{ $siswa->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $siswa->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 text-gray-600 font-medium">{{ $siswa->asal_sekolah ?? '-' }}</td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-bold">
                                            {{ $siswa->departemen_lpkia ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-gray-600 text-xs">
                                        @if($siswa->tanggal_mulai_pkl)
                                            {{ date('d M Y', strtotime($siswa->tanggal_mulai_pkl)) }} - {{ date('d M Y', strtotime($siswa->tanggal_selesai_pkl)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($siswa->nisn && $siswa->no_hp && $siswa->alamat)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">
                                                Lengkap ✅
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800">
                                                Belum Lengkap ⏳
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center whitespace-nowrap">
                                        <div class="flex justify-center gap-1">
                                            <!-- EDIT -->
                                            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded shadow-sm transition">
                                                ✏️ Edit
                                            </a>

                                            <!-- HAPUS SATUAN -->
                                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-red-500 hover:bg-red-600 text-white font-bold text-xs rounded shadow-sm transition">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data siswa PKL.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>