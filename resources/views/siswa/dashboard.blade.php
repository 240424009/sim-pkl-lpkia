<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- BANNER WELCOME SISWA -->
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
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h3>
                    <p class="text-sm text-blue-100/80 mt-1 max-w-xl">
                        Anda login sebagai <span class="font-bold text-amber-300">SISWA PKL</span>. Jangan lupa untuk mengisi presensi harian, jurnal kegiatan, dan perizinan Anda.
                    </p>
                </div>
            </div>

            <!-- KARTU UTAMA SISWA (Layout 3 Kolom Modern) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- ⏰ CARD 1: PRESENSI HARIAN -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-50/90 via-white to-teal-50/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 border border-emerald-100 hover:border-emerald-400">
                    <!-- Motif Background Aksen -->
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-xs font-extrabold text-emerald-900/60 uppercase tracking-wider">Aktivitas Harian</p>
                            <h4 class="text-xl font-bold text-emerald-950 mt-2">
                                Presensi Harian
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                Catat jam masuk dan jam pulang PKL Anda hari ini.
                            </p>
                            <a href="{{ route('siswa.presensi.index') }}" class="inline-flex items-center text-xs font-bold text-emerald-600 hover:text-emerald-800 mt-4 group-hover:translate-x-1 transition-transform duration-200">
                                Buka Presensi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                        <div class="p-3.5 bg-emerald-100/80 rounded-2xl text-emerald-600 group-hover:scale-110 shadow-sm transition-transform duration-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- 📝 CARD 2: JURNAL KEGIATAN -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-50/90 via-white to-blue-50/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 border border-indigo-100 hover:border-indigo-400">
                    <!-- Motif Background Aksen -->
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-xs font-extrabold text-indigo-900/60 uppercase tracking-wider">Laporan Kerja</p>
                            <h4 class="text-xl font-bold text-indigo-950 mt-2">
                                Jurnal Kegiatan
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                Isi rincian pekerjaan dan tugas harian PKL Anda.
                            </p>
                            <a href="{{ route('siswa.jurnal.index') }}" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-800 mt-4 group-hover:translate-x-1 transition-transform duration-200">
                                Buka Jurnal
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                        <div class="p-3.5 bg-indigo-100/80 rounded-2xl text-indigo-600 group-hover:scale-110 shadow-sm transition-transform duration-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- 📥 CARD 3: IZIN / SAKIT -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-amber-50/90 via-white to-orange-50/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 border border-amber-100 hover:border-amber-400">
                    <!-- Motif Background Aksen -->
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none group-hover:scale-150 transition-transform duration-300"></div>
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-500"></div>

                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-xs font-extrabold text-amber-900/60 uppercase tracking-wider">Ketidakhadiran</p>
                            <h4 class="text-xl font-bold text-amber-950 mt-2">
                                Izin / Sakit
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                Ajukan surat perizinan atau pemberitahuan sakit PKL.
                            </p>
                            <a href="{{ route('siswa.perizinan.index') }}" class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-800 mt-4 group-hover:translate-x-1 transition-transform duration-200">
                                Ajukan Izin
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                        <div class="p-3.5 bg-amber-100/80 rounded-2xl text-amber-600 group-hover:scale-110 shadow-sm transition-transform duration-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>