<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembimbing PKL LPKIA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- BANNER WELCOME -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Selamat Datang, Pembimbing PKL LPKIA! 👋</h3>
                <p class="text-sm text-gray-500 mt-1">Anda login sebagai <span class="font-semibold text-indigo-600">Pembimbing PKL LPKIA (Admin)</span>.</p>
            </div>

            <!-- KARTU STATISTIK & MENU (3 KOLOM) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- 📊 CARD 1: TOTAL SISWA PKL -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-indigo-600 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Siswa PKL</p>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalSiswa ?? 0 }}</h4>
                        <a href="{{ route('admin.siswa.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                            Lihat Detail Data Siswa →
                        </a>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600 text-2xl">
                        👥
                    </div>
                </div>

                <!-- 📱 CARD 2: QR CODE PRESENSI -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-800 text-base">QR Code Presensi</h4>
                        <p class="text-xs text-gray-500 mt-1">Tampilkan QR Code harian untuk di-scan siswa.</p>
                        <a href="{{ route('admin.qr.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 mt-3 inline-block">
                            Tampilkan QR Code →
                        </a>
                    </div>
                    <div class="text-3xl">📱</div>
                </div>

                <!-- 📝 CARD 3: VERIFIKASI JURNAL -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-800 text-base">Verifikasi Jurnal</h4>
                        <p class="text-xs text-gray-500 mt-1">Cek dan berikan penilaian/approval jurnal.</p>
                        <a href="{{ route('admin.jurnal.index') }}" class="text-xs font-semibold text-green-600 hover:text-green-800 mt-3 inline-block">
                            Buka Verifikasi →
                        </a>
                    </div>
                    <div class="text-3xl">📝</div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>