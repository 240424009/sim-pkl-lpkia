<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Code Presensi Harian LPKIA') }}
        </h2>
    </x-slot>

    <div class="py-12 text-center">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h3 class="text-lg font-bold text-gray-700 mb-2">Scan QR Code Ini Untuk Presensi</h3>
            <p class="text-sm text-gray-500 mb-6">Tanggal: {{ date('d F Y') }}</p>

            <div class="flex justify-center mb-6">
                <!-- Generate QR Code pake token sederhana harita -->
                {!! QrCode::size(250)->generate('PRESENSI_LPKIA_' . date('Y-m-d')) !!}
            </div>

            <!-- Tombol Presensi Manual khusus pikeun Siswa kendala HP -->
            <div class="mt-4">
                <a href="{{ route('admin.presensi.manual.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-lg shadow-sm transition">
                    <span>✏️</span> Input Presensi Manual (HP Siswa Bermasalah)
                </a>
            </div>

            <p class="text-xs text-gray-400">Arahkan kamera/scanner siswa ke QR Code di atas.</p>
        </div>
    </div>
</x-app-layout>