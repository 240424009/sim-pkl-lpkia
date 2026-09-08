<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembimbing PKL') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- BANNER WELCOME MODERN -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-indigo-900 to-blue-800 rounded-2xl p-6 sm:p-8 shadow-xl text-white">
                <!-- Background Decorative Pattern -->
                <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
                    <svg width="300" height="300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>

                <div class="relative z-10">
                    <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-lg text-xs font-medium text-blue-200 mb-3">
                        <span>👋 Selamat Datang kembali</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight">
                        Sistem Informasi & Monitoring PKL
                    </h3>
                    <p class="text-sm text-blue-100/80 mt-1 max-w-xl">
                        Anda login sebagai <span class="font-bold text-amber-300">Pembimbing PKL LPKIA (Admin)</span>. Kelola data presensi, jurnal, dan aktivitas siswa di sini.
                    </p>
                </div>
            </div>

            <!-- KARTU STATISTIK & MENU UTAMA -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 📊 CARD 1: TOTAL SISWA PKL -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-50/90 via-white to-blue-50/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 border border-indigo-100 hover:border-indigo-400">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-xs font-extrabold text-indigo-900/60 uppercase tracking-wider">Total Siswa PKL</p>
                            <h4 class="text-4xl font-black text-indigo-950 mt-2 tracking-tight">
                                {{ $totalSiswa ?? 0 }}
                            </h4>
                            <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800 mt-4 group-hover:translate-x-1 transition-transform duration-200 after:absolute after:inset-0">
                                Lihat Detail Data Siswa
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                        <div class="p-3.5 bg-indigo-100/80 rounded-2xl text-indigo-600 group-hover:scale-110 shadow-sm transition-transform duration-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- 📱 CARD 2: PRESENSI HARIAN -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-sky-50/90 via-white to-blue-50/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 border border-sky-100 hover:border-sky-400">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-sky-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-sky-500"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-xs font-extrabold text-sky-900/60 uppercase tracking-wider">Presensi Harian (Hari Ini)</p>
                            <h4 class="text-3xl font-black text-sky-950 mt-2 tracking-tight">
                                {{ $presensiHariIniCount ?? 0 }} <span class="text-sm font-semibold text-slate-500">/ {{ $totalSiswa ?? 0 }} Siswa</span>
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                Tampilkan QR Code harian untuk di-scan oleh siswa PKL.
                            </p>
                            <a href="{{ route('admin.qr.index') }}" class="inline-flex items-center text-xs font-bold text-sky-600 hover:text-sky-800 mt-4 group-hover:translate-x-1 transition-transform duration-200 after:absolute after:inset-0">
                                Tampilkan QR Code
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                        <div class="p-3.5 bg-sky-100/80 rounded-2xl text-sky-600 group-hover:scale-110 shadow-sm transition-transform duration-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- 📝 CARD 3: VERIFIKASI JURNAL -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-50/90 via-white to-teal-50/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 border border-emerald-100 hover:border-emerald-400">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-xs font-extrabold text-emerald-900/60 uppercase tracking-wider">Jurnal Kegiatan</p>
                            <h4 class="text-xl font-bold text-emerald-950 mt-2">
                                Verifikasi Jurnal
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                Cek dan berikan penilaian / approval jurnal siswa.
                            </p>
                            <a href="{{ route('admin.jurnal.index') }}" class="inline-flex items-center text-xs font-bold text-emerald-600 hover:text-emerald-800 mt-4 group-hover:translate-x-1 transition-transform duration-200 after:absolute after:inset-0">
                                Buka Verifikasi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                        <div class="p-3.5 bg-emerald-100/80 rounded-2xl text-emerald-600 group-hover:scale-110 shadow-sm transition-transform duration-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- ✉️ CARD 4: VERIFIKASI PERIZINAN -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-amber-50/90 via-white to-orange-50/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 border border-amber-100 hover:border-amber-400">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-500"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-xs font-extrabold text-amber-900/60 uppercase tracking-wider">Perizinan Siswa</p>
                            <h4 class="text-xl font-bold text-amber-950 mt-2">
                                Verifikasi Perizinan
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                Cek surat izin & ketidakhadiran siswa PKL.
                            </p>
                            <a href="{{ route('admin.perizinan.index') }}" class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-800 mt-4 group-hover:translate-x-1 transition-transform duration-200 after:absolute after:inset-0">
                                Buka Verifikasi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                        <div class="p-3.5 bg-amber-100/80 rounded-2xl text-amber-600 group-hover:scale-110 shadow-sm transition-transform duration-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 📋 TABEL RINGKASAN PRESENSI HARI INI -->
            <div class="bg-gradient-to-b from-white via-slate-50/50 to-blue-50/30 rounded-2xl shadow-sm border border-slate-200 p-6 overflow-hidden relative">
                <!-- Hiasan Blur Background Soft -->
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-blue-400/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight">Presensi Masuk Hari Ini</h3>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Ringkasan 5 siswa terbaru yang melakukan scan QR code hari ini.</p>
                    </div>

                    <a href="{{ route('admin.presensi.rekap') }}" class="inline-flex items-center text-xs font-bold text-blue-700 hover:text-blue-900 bg-blue-100/80 hover:bg-blue-200/80 px-4 py-2 rounded-xl transition-all duration-200 shadow-xs border border-blue-200/50">
                        Lihat Selengkapnya
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- Container Tabel ku Background & Border Modern -->
                <div class="relative z-10 overflow-x-auto rounded-xl border border-slate-200/80 shadow-xs bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-extrabold text-slate-700 uppercase tracking-wider bg-gradient-to-r from-slate-100 via-blue-50/60 to-slate-100">
                                <th class="py-3.5 px-5">Nama Siswa</th>
                                <th class="py-3.5 px-5">Waktu Scan</th>
                                <th class="py-3.5 px-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($presensiHariIni as $item)
                                <tr class="hover:bg-blue-50/40 transition-colors">
                                    <td class="py-4 px-5 font-bold text-slate-800">
                                        {{ $item->user->name ?? 'Siswa' }}
                                    </td>
                                    <td class="py-4 px-5 text-slate-600 font-semibold">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB
                                    </td>
                                    <td class="py-4 px-5 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-700 border border-emerald-300 shadow-2xs">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                                            Hadir
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-slate-400 font-medium italic bg-slate-50/60">
                                        Belum ada siswa yang melakukan presensi hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>