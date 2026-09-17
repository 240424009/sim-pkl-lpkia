<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekapan Presensi Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                <!-- HEADER JUDUL, FILTER, JEUNG TOMBOL ACTION -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-700">Rekapan Kehadiran Siswa</h3>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- FORM FILTER ASAL SEKOLAH -->
                        <form method="GET" action="{{ route('guru.presensi') }}" class="flex items-center gap-2">
                            <select name="sekolah" onchange="this.form.submit()" class="w-64 min-w-[220px] text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-2xs py-2 pl-3 pr-8 text-gray-700 truncate cursor-pointer">
                                <option value="">-- Semua Sekolah --</option>
                                @foreach($sekolahs as $sekolah)
                                    <option value="{{ $sekolah }}" {{ request('sekolah') == $sekolah ? 'selected' : '' }}>
                                        {{ $sekolah }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <!-- TOMBOL KEMBALI -->
                        <a href="{{ route('guru.dashboard') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded shadow transition inline-flex items-center gap-1">
                            ⬅️ Kembali
                        </a>

                        <!-- TOMBOL EXPORT PDF (NGAIKUTAN FILTER SEKOLAH) -->
                        <a href="{{ route('guru.presensi.pdf', ['sekolah' => request('sekolah')]) }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded shadow transition inline-flex items-center gap-1">
                            📄 Export PDF
                        </a>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <th class="py-3 px-4">Nama Siswa</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4 text-center">Total Hadir</th>
                                <th class="py-3 px-4 text-center">Total Terlambat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($siswas as $siswa)
                                <tr>
                                    <td class="py-3 px-4 font-bold text-gray-800">
                                        {{ $siswa->name }}
                                        <div class="text-xs text-gray-400 font-normal">{{ $siswa->asal_sekolah ?? '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-600">{{ $siswa->email }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded font-bold">
                                            {{ $siswa->presensis->where('status', 'hadir')->count() }} Hari
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-1 rounded font-bold">
                                            {{ $siswa->presensis->where('status', 'terlambat')->count() }} Hari
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>