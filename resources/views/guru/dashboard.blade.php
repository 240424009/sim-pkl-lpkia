<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru Pembimbing Sekolah') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- WELCOME BANNER -->
            <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 24px; border-radius: 16px; margin-bottom: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h3 style="font-size: 24px; font-weight: 800; color: white; margin-bottom: 4px;">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p style="font-size: 14px; color: #dbeafe;">Anda dapat memantau ringkasan presensi harian dan aktivitas siswa bimbingan secara real-time.</p>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    
                <!-- 1. Total Siswa (Indigo/Biru) -->
                <div style="background: linear-gradient(to right, #eef2ff, #ffffff); border: 1px solid #e0e7ff; border-left: 5px solid #6366f1; padding: 24px; border-radius: 16px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="font-size: 11px; font-weight: 800; color: #6366f1; text-transform: uppercase; letter-spacing: 0.05em;">Total Siswa PKL</p>
                        <h4 style="font-size: 40px; font-weight: 900; color: #1e1b4b; margin-top: 4px;">{{ $totalSiswa }}</h4>
                        <a href="{{ route('guru.presensi') }}" style="display: inline-block; margin-top: 12px; font-size: 12px; font-weight: 700; color: #4f46e5; text-decoration: none;">Lihat Rekapan Presensi →</a>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background-color: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 24px;">👥</div>
                </div>

                <!-- 2. Hadir Hari Ini (Héjo/Cyan) -->
                <div style="background: linear-gradient(to right, #ecfdf5, #ffffff); border: 1px solid #d1fae5; border-left: 5px solid #10b981; padding: 24px; border-radius: 16px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="font-size: 11px; font-weight: 800; color: #10b981; text-transform: uppercase; letter-spacing: 0.05em;">Hadir Hari Ini</p>
                        <h4 style="font-size: 40px; font-weight: 900; color: #064e3b; margin-top: 4px;">{{ $totalHadir }} <span style="font-size: 16px; font-weight: 600; color: #6ee7b7;">/ {{ $totalSiswa }} Siswa</span></h4>
                        <a href="{{ route('guru.presensi') }}" style="display: inline-block; margin-top: 12px; font-size: 12px; font-weight: 700; color: #059669; text-decoration: none;">Pantau Jam Masuk →</a>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background-color: #d1fae5; color: #047857; display: flex; align-items: center; justify-content: center; font-size: 24px;">✅</div>
                </div>

                <!-- 3. Izin / Sakit (Amber/Oren) -->
                <div style="background: linear-gradient(to right, #fffbeb, #ffffff); border: 1px solid #fef3c7; border-left: 5px solid #f59e0b; padding: 24px; border-radius: 16px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="font-size: 11px; font-weight: 800; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.05em;">Izin / Sakit</p>
                        <h4 style="font-size: 40px; font-weight: 900; color: #78350f; margin-top: 4px;">{{ $totalIzinSakit }} <span style="font-size: 16px; font-weight: 600; color: #fcd34d;">Siswa</span></h4>
                        <a href="{{ route('guru.presensi') }}" style="display: inline-block; margin-top: 12px; font-size: 12px; font-weight: 700; color: #d97706; text-decoration: none;">Cek Keterangan →</a>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background-color: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 24px;">📩</div>
                </div>

                <!-- 4. Tanpa Keterangan (Beureum) -->
                <div style="background: linear-gradient(to right, #fff1f2, #ffffff); border: 1px solid #ffe4e6; border-left: 5px solid #f43f5e; padding: 24px; border-radius: 16px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="font-size: 11px; font-weight: 800; color: #f43f5e; text-transform: uppercase; letter-spacing: 0.05em;">Tanpa Keterangan</p>
                        <h4 style="font-size: 40px; font-weight: 900; color: #881337; margin-top: 4px;">{{ $totalAlpha }} <span style="font-size: 16px; font-weight: 600; color: #fda4af;">Siswa</span></h4>
                        <a href="{{ route('guru.presensi') }}" style="display: inline-block; margin-top: 12px; font-size: 12px; font-weight: 700; color: #e11d48; text-decoration: none;">Cek Siswa Alpha →</a>
                    </div>
                    <div style="width: 48px; height: 48px; border-radius: 12px; background-color: #ffe4e6; color: #be123c; display: flex; align-items: center; justify-content: center; font-size: 24px;">⚠️</div>
                </div>

            </div>

            <!-- GRID DUA KOLOM: PRESENSI & JURNAL -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- 1. PRESENSI HARI INI -->
                <div class="bg-white rounded-2xl shadow-2xs border border-slate-200 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-base font-extrabold text-slate-800">Presensi Hari Ini</h3>
                                <p class="text-xs text-slate-500">Aktivitas masuk & pulang siswa</p>
                            </div>
                            <a href="{{ route('guru.presensi') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                                Lihat Rekapan →
                            </a>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-slate-100">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase font-extrabold border-b border-slate-100">
                                        <th class="py-3 px-4">Siswa</th>
                                        <th class="py-3 px-4">Masuk</th>
                                        <th class="py-3 px-4">Pulang</th>
                                        <th class="py-3 px-4 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($presensiHariIni->take(5) as $item)
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="py-3 px-4 font-bold text-slate-800">{{ $item->user->name ?? 'Siswa' }}</td>
                                            <td class="py-3 px-4 text-emerald-600 font-bold">
                                                {{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}
                                            </td>
                                            <td class="py-3 px-4 text-amber-600 font-bold">
                                                {{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}
                                            </td>
                                            <td class="py-3 px-4 text-right">
                                                <span class="px-2.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800">
                                                    {{ ucfirst($item->status ?? 'Hadir') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-6 text-center text-slate-400 italic">Belum ada presensi hari ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 2. JURNAL KEGIATAN TERBARU -->
                <div class="bg-white rounded-2xl shadow-2xs border border-slate-200 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-base font-extrabold text-slate-800">Jurnal Harian Terbaru</h3>
                                <p class="text-xs text-slate-500">Laporan kegiatan harian siswa</p>
                            </div>
                            <a href="{{ route('guru.jurnal') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                                Lihat Semua →
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($jurnalTerbaru as $jurnal)
                                <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/50 flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">{{ $jurnal->user->name ?? 'Siswa' }}</h4>
                                        <p class="text-xs text-slate-600 mt-1 line-clamp-1">{{ $jurnal->kegiatan ?? $jurnal->ringkasan ?? '-' }}</p>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-400 bg-white px-2 py-1 rounded-md border border-slate-200">
                                        {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-center py-6 text-slate-400 text-xs italic">Belum ada jurnal yang diisi siswa.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>