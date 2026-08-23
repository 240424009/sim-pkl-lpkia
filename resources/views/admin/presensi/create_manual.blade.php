<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Presensi Manual Siswa (Admin)') }}
            </h2>
            <!-- Tombol Kembali dina Header -->
            <a href="{{ route('admin.qr.index') }}" class="px-3 py-1.5 bg-gray-500 hover:bg-gray-600 text-white font-bold text-xs rounded-lg shadow-sm transition">
                ⬅ Kembali ke QR Presensi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm font-bold">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.presensi.manual.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Siswa</label>
                        <select name="user_id" class="w-full text-sm rounded-lg border-gray-300" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-lg border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jam Masuk</label>
                            <input type="time" name="jam_masuk" value="{{ date('H:i') }}" class="w-full text-sm rounded-lg border-gray-300" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Kehadiran</label>
                        <select name="status" class="w-full text-sm rounded-lg border-gray-300" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alfa">Alfa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Keterangan (Opsional)</label>
                        <textarea name="keterangan" placeholder="Contoh: HP siswa rusak / batre béak" class="w-full text-sm rounded-lg border-gray-300" rows="2"></textarea>
                    </div>

                    <!-- Tombol Aksi di Handap Form -->
                    <div class="pt-2 flex gap-2">
                        <a href="{{ route('admin.qr.index') }}" class="w-1/3 text-center bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                            Batal
                        </a>
                        <button type="submit" class="w-2/3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                            Simpan Presensi Manual
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>