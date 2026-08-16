<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Data Siswa PKL Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">

                <!-- 🔴 PESAN ERROR VALIDASI (Bakal muncul mun aya data salah/kembar) -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded text-sm">
                        <p class="font-bold">Aya anu lepat dina inputan:</p>
                        <ul class="list-disc pl-5 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Nama Lengkap Siswa</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Email (Untuk Akun Login Siswa)</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Contoh: SMK Negeri 1 Bandung" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Ditempatkan Di Departemen LPKIA</label>
                        <select name="departemen_lpkia" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">-- Pilih Departemen --</option>
                            <option value="Biro Administrasi Umum" {{ old('departemen_lpkia') == 'Biro Administrasi Umum' ? 'selected' : '' }}>Biro Administrasi Umum</option>
                            <option value="Biro Admnistrasi Akademik" {{ old('departemen_lpkia') == 'Biro Admnistrasi Akademik' ? 'selected' : '' }}>Biro Admnistrasi Akademik</option>
                            <option value="Biro Administrasi Sumber daya" {{ old('departemen_lpkia') == 'Biro Administrasi Sumber daya' ? 'selected' : '' }}>BAS</option>
                            <option value="MIS" {{ old('departemen_lpkia') == 'MIS' ? 'selected' : '' }}>MIS</option>
                            <option value="Departemen Umum" {{ old('departemen_lpkia') == 'Departemen Umum' ? 'selected' : '' }}>Departemen Umum</option>
                            <option value="Prodi Teknik Informatika" {{ old('departemen_lpkia') == 'Prodi Teknik Informatika' ? 'selected' : '' }}>Prodi Teknik Informatika</option>
                            <option value="Prodi Sistem Informasi" {{ old('departemen_lpkia') == 'Prodi Sistem Informasi' ? 'selected' : '' }}>Prodi Sistem Informasi</option>
                            <option value="Prodi Akuntansi" {{ old('departemen_lpkia') == 'Prodi Akuntansi' ? 'selected' : '' }}>Prodi Akuntansi</option>
                            <option value="Prodi Administrasi Bisnis" {{ old('departemen_lpkia') == 'Prodi Administrasi Bisnis' ? 'selected' : '' }}>Prodi Administrasi Bisnis</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Tanggal Mulai PKL</label>
                            <input type="date" name="tanggal_mulai_pkl" value="{{ old('tanggal_mulai_pkl') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Tanggal Selesai PKL</label>
                            <input type="date" name="tanggal_selesai_pkl" value="{{ old('tanggal_selesai_pkl') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end space-x-2">
                        <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md font-bold text-sm hover:bg-gray-300">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md font-bold text-sm hover:bg-indigo-700">Simpan Data Siswa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>