<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Kartu Selamat Datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}! 👋</h3>
                <p class="mt-2 text-gray-600">
                    Anda login sebagai <span class="font-semibold text-indigo-600 uppercase">Siswa PKL</span>. Jangan lupa untuk mengisi presensi harian dan jurnal kegiatan Anda hari ini.
                </p>
            </div>

            <!-- Grid Menu Cepat (Quick Links) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card Presensi -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-gray-700 text-lg">Presensi Harian</h4>
                        <p class="text-sm text-gray-500 mt-1">Catat jam masuk dan jam pulang PKL Anda.</p>
                        <a href="{{ route('siswa.presensi.index') }}" class="inline-block mt-4 text-sm font-bold text-green-600 hover:text-green-800">
                            Buka Presensi &rarr;
                        </a>
                    </div>
                    <div class="text-4xl">⏰</div>
                </div>

                <!-- Card Jurnal Kegiatan -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-gray-700 text-lg">Jurnal Kegiatan</h4>
                        <p class="text-sm text-gray-500 mt-1">Isi rincian pekerjaan dan tugas harian Anda.</p>
                        <a href="{{ route('siswa.jurnal.index') }}" class="inline-block mt-4 text-sm font-bold text-blue-600 hover:text-blue-800">
                            Buka Jurnal &rarr;
                        </a>
                    </div>
                    <div class="text-4xl">📝</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>