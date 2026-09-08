<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Rekap Detail Presensi Siswa') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER & FORM FILTER MODERN -->
            <div class="bg-gradient-to-b from-white to-slate-50/60 rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden">
                <!-- Hiasan Glow Background -->
                <div class="absolute -top-10 -right-10 w-36 h-36 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 relative z-10">
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Laporan Riwayat Presensi</h3>
                        <p class="text-sm font-medium text-slate-500 mt-0.5">Monitor lan rekap sadaya kehadiran harian siswa PKL.</p>
                    </div>

                    <!-- Tombol Kembali ka Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-xs font-bold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-100 border border-slate-200 px-4 py-2.5 rounded-xl shadow-xs transition-all duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Dashboard
                    </a>
                </div>

                <!-- Form Filter -->
                <form method="GET" action="{{ route('admin.presensi.rekap') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 relative z-10 bg-white/80 p-4 rounded-xl border border-slate-200/80 shadow-2xs">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Filter Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full text-sm font-medium rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 py-2">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Filter Siswa</label>
                        <select name="siswa_id" class="w-full text-sm font-medium rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 py-2">
                            <option value="">-- Semua Siswa --</option>
                            @foreach($listSiswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-2 px-4 rounded-xl shadow-xs transition-all duration-200">
                            Cari Data
                        </button>
                        @if(request('tanggal') || request('siswa_id'))
                            <a href="{{ route('admin.presensi.rekap') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-sm py-2 px-4 rounded-xl transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TABEL REKAP DETAIL CANTIK -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 overflow-hidden">
                <div class="overflow-x-auto rounded-xl border border-slate-200/80 shadow-2xs bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-extrabold text-slate-700 uppercase tracking-wider bg-gradient-to-r from-slate-100 via-blue-50/60 to-slate-100">
                                <th class="py-3.5 px-5">Tanggal</th>
                                <th class="py-3.5 px-5">Nama Siswa</th>
                                <th class="py-3.5 px-5">Jam Masuk</th>
                                <th class="py-3.5 px-5">Jam Pulang</th>
                                <th class="py-3.5 px-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($presensi as $item)
                                <tr class="hover:bg-blue-50/40 transition-colors">
                                    <td class="py-4 px-5 font-semibold text-slate-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="py-4 px-5 font-bold text-slate-800">
                                        {{ $item->user->name ?? 'Siswa (Terhapus)' }}
                                    </td>
                                    <td class="py-4 px-5 font-bold text-emerald-600">
                                        {{ $item->jam_masuk ?? '-' }}
                                    </td>
                                    <td class="py-4 px-5 font-bold text-amber-600">
                                        {{ $item->jam_pulang ?? '-' }}
                                    </td>
                                    <td class="py-4 px-5 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300/60 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                                            Hadir
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-slate-400 font-medium italic bg-slate-50/50">
                                        Tidak ada data presensi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $presensi->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>