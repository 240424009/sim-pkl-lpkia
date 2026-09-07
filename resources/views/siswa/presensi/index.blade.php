<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presensi Harian PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Alert Notifikasi -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Card Tombol Presensi -->
            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                <h3 class="text-lg font-bold text-gray-700 mb-2">Presensi Hari Ini</h3>
                <p class="text-sm text-gray-500 mb-6">{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>

                <!-- 🟢 TOMBOL UTAMA: SCAN QR CODE -->
                <div class="mb-6">
                    <a href="{{ route('siswa.scan.index') }}" 
                       class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition transform active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        <span>📷 Buka Kamera Scan QR Code</span>
                    </a>
                </div>

                <div class="relative flex py-2 items-center mb-6">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 text-gray-400 text-xs uppercase font-semibold">Atanapi Presensi Manual</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <!-- TOMBOL MANUAL (MASUK & PULANG) -->
                <div class="flex justify-center gap-4">
                    <!-- Tombol Masuk -->
                    <form action="{{ route('siswa.presensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipe" value="masuk">
                        <button type="submit" 
                            @if($presensiHariIni) disabled @endif
                            class="px-6 py-3 rounded-lg font-bold text-white transition {{ $presensiHariIni ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }}">
                            {{ $presensiHariIni ? 'Sudah Presensi Masuk' : 'Presensi Masuk' }}
                        </button>
                    </form>

                    <!-- Tombol Pulang -->
                    <form action="{{ route('siswa.presensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipe" value="pulang">
                        <button type="submit" 
                            @if(!$presensiHariIni || $presensiHariIni->jam_pulang !== null) disabled @endif
                            class="px-6 py-3 rounded-lg font-bold text-white transition {{ (!$presensiHariIni || $presensiHariIni->jam_pulang !== null) ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }}">
                            {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'Sudah Presensi Pulang' : 'Presensi Pulang' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Riwayat Presensi -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Riwayat Presensi</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Jam Masuk</th>
                                <th class="py-3 px-4">Jam Pulang</th>
                                <th class="py-3 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($riwayatPresensi as $row)
                                <tr>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                    <td class="py-3 px-4">{{ $row->jam_masuk ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $row->jam_pulang ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if($row->status === 'hadir')
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Hadir</span>
                                        @elseif($row->status === 'terlambat')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Terlambat</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">{{ ucfirst($row->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">Belum ada riwayat presensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>