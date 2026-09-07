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

            <!-- 🟢 CARD UTAMA PRESENSI HARI INI (HIGHLIGHTED) -->
            <div class="bg-white p-8 rounded-2xl shadow-md border-t-4 border-indigo-600 text-center">
                <div class="mb-6">
                    <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 font-semibold text-xs rounded-full mb-2">
                        Status Presensi
                    </span>
                    <h3 class="text-2xl font-extrabold text-gray-800">Presensi Hari Ini</h3>
                    <p class="text-sm font-medium text-gray-500 mt-1">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>

                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 max-w-xl mx-auto">
                    <!-- 🟢 TOMBOL UTAMA: SCAN QR CODE -->
                    @if(!$presensiHariIni)
                        <a href="{{ route('siswa.scan.index') }}" 
                           class="inline-flex items-center justify-center gap-3 w-full sm:w-1/2 px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-200 transition transform active:scale-95">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            <span class="text-base">Scan QR Masuk</span>
                        </a>
                    @else
                        <div class="w-full sm:w-1/2 py-3.5 px-4 bg-green-50 border border-green-200 text-green-700 font-bold rounded-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Sudah Masuk ({{ $presensiHariIni->jam_masuk }})</span>
                        </div>
                    @endif

                    <!-- 🔵 TOMBOL PRESENSI PULANG -->
                    <form action="{{ route('siswa.presensi.store') }}" method="POST" class="w-full sm:w-1/2">
                        @csrf
                        <input type="hidden" name="tipe" value="pulang">
                        <button type="submit" 
                            @if(!$presensiHariIni || $presensiHariIni->jam_pulang !== null) disabled @endif
                            class="w-full py-4 px-6 rounded-xl font-bold text-base transition {{ (!$presensiHariIni || $presensiHariIni->jam_pulang !== null) ? 'bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-lg hover:shadow-blue-200 active:scale-95' }}">
                            {{ ($presensiHariIni && $presensiHariIni->jam_pulang) ? 'Sudah Pulang' : 'Presensi Pulang' }}
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