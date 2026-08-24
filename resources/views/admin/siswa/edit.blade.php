<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit & Detail Biodata Siswa') }}
            </h2>
            <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold text-xs rounded-lg shadow transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm font-semibold rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: DATA AKUN & PENEMPATAN PKL -->
                    <div class="mb-6">
                        <h3 class="text-md font-bold text-indigo-700 border-b pb-2 mb-4">📌 Data Akun & Penempatan LPKIA</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $siswa->name) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email', $siswa->email) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Asal Sekolah</label>
                                <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Departemen LPKIA</label>
                                <select name="departemen_lpkia" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="Biro Adiministrasi Umum" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Biro Adiministrasi Umum' ? 'selected' : '' }}>Biro Adiministrasi Umum</option>
                                    <option value="Biro Administrasi Akademik" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Biro Administrasi Akademik' ? 'selected' : '' }}>Biro Administrasi Akademik</option>
                                    <option value="Biro Administrasi Sumber Daya" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Biro Administrasi Sumber Daya' ? 'selected' : '' }}>Biro Administrasi Sumber Daya</option>
                                    <option value="MIS" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'MIS' ? 'selected' : '' }}>MIS</option>
                                    <option value="Prodi Teknik Informatika" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Prodi Teknik Informatika' ? 'selected' : '' }}>Prodi Teknik Informatika</option>
                                    <option value="Prodi Sistem Informasi" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Prodi Sistem Informasi' ? 'selected' : '' }}>Prodi Sistem Informasi</option>
                                    <option value="Prodi Akuntansi" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Prodi Akuntansi' ? 'selected' : '' }}>Prodi Akuntansi</option>
                                    <option value="Prodi Administrasi Bisnis" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Prodi Administrasi Bisnis' ? 'selected' : '' }}>Prodi Administrasi Bisnis</option>
                                    <option value="Departemen Umum" {{ old('departemen_lpkia', $siswa->departemen_lpkia) == 'Departemen Umum' ? 'selected' : '' }}>Departemen Umum</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai PKL</label>
                                <input type="date" name="tanggal_mulai_pkl" value="{{ old('tanggal_mulai_pkl', $siswa->tanggal_mulai_pkl) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai PKL</label>
                                <input type="date" name="tanggal_selesai_pkl" value="{{ old('tanggal_selesai_pkl', $siswa->tanggal_selesai_pkl) }}" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: BIODATA LENGKAP SISWA -->
                    <div class="mb-6">
                        <h3 class="text-md font-bold text-indigo-700 border-b pb-2 mb-4">👤 Biodata Lengkap Siswa</h3>
                        
                        <!-- 🟢 TAMPILAN PAS FOTO SISWA -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pas Foto Siswa</label>
                            @if($siswa->foto)
                                <img src="{{ route('preview.bukti', $siswa->foto) }}" 
                                    alt="Pas Foto {{ $siswa->name }}" 
                                    class="w-32 h-40 object-cover rounded-lg border-2 border-indigo-500 shadow-sm">
                            @else
                                <div class="w-32 h-40 bg-gray-100 rounded-lg border border-gray-300 flex items-center justify-center text-gray-400 text-xs">
                                    Belum Upload Foto
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NISN</label>
                                <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Contoh: 0051234567" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. HP / Whatsapp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" placeholder="Contoh: 081234567890" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Orang Tua / Wali</label>
                                <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}" placeholder="Nama Ayah/Ibu/Wali" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" placeholder="Alamat rumah lengkap..." class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('alamat', $siswa->alamat) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: RESET PASSWORD (OPTIONAL) -->
                    <div class="mb-6">
                        <h3 class="text-md font-bold text-gray-700 border-b pb-2 mb-4">🔑 Ganti Password (Opsional)</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah password" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-lg shadow transition">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>