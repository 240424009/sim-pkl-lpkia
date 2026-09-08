<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Rekap Detail Presensi Siswa') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER & FORM FILTER -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800">Laporan Riwayat Presensi</h3>
                        <p class="text-xs text-slate-500">Monitor lan rekap sadaya kehadiran harian siswa PKL.</p>
                    </div>

                    <!-- Tombol Kembali ka Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 px-4 py-2 rounded-xl transition-colors">
                        ← Kembali ke Dashboard
                    </a>
                </div>

                <!-- Form Filter -->
                <form method="GET" action="{{ route('admin.presensi.rekap') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Filter Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Filter Siswa</label>
                        <select name="siswa_id" class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua Siswa --</option>
                            @foreach($listSiswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl transition-colors">
                            Cari Data
                        </button>
                        @if(request('tanggal') || request('siswa_id'))
                            <a href="{{ route('admin.presensi.rekap') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TABEL REKAP DETAIL -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50">
                                <th class="py-3.5 px-4 rounded-l-lg">Tanggal</th>
                                <th class="py-3.5 px-4">Nama Siswa</th>
                                <th class="py-3.5 px-4">Jam Masuk</th>
                                <th class="py-3.5 px-4">Jam Pulang</th>
                                <th class="py-3.5 px-4 rounded-r-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($presensi as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-slate-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-800">
                                        {{ $item->user->name ?? 'Siswa (Terhapus)' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-emerald-600 font-semibold">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-amber-600 font-semibold">
                                        {{ $item->jam_pulang ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                            ● Hadir
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                        Tidak ada data presensi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $presensi->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>