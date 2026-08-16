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