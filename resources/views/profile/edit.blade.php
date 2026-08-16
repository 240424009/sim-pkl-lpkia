<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 🟢 FORM BIODATA SISWA (Ngan nampil pikeun role Siswa) -->
            @if(auth()->user()->role === 'siswa')
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-indigo-500">
                <div class="max-w-xl">
                    <h2 class="text-lg font-bold text-gray-900">📋 Biodata Lengkap Siswa PKL</h2>
                    <p class="mt-1 text-sm text-gray-600">Silahkan lengkapi data pribadi anda dibawah ini untuk kelengkapan berkas PKL.</p>

                    <!-- Informasi Penempatan ti Admin -->
                    <div class="mt-4 p-3 bg-indigo-50 rounded-md text-sm text-indigo-900 space-y-1">
                        <p><strong>Asal Sekolah:</strong> {{ auth()->user()->asal_sekolah ?? '-' }}</p>
                        <p><strong>Departemen LPKIA:</strong> {{ auth()->user()->departemen_lpkia ?? '-' }}</p>
                        <p><strong>Periode PKL:</strong> 
                            {{ auth()->user()->tanggal_mulai_pkl ? date('d M Y', strtotime(auth()->user()->tanggal_mulai_pkl)) : '-' }} 
                            s/d 
                            {{ auth()->user()->tanggal_selesai_pkl ? date('d M Y', strtotime(auth()->user()->tanggal_selesai_pkl)) : '-' }}
                        </p>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="name" value="{{ old('name', $user->name) }}">
                        <input type="hidden" name="email" value="{{ old('email', $user->email) }}">

                        <div>
                            <x-input-label for="nisn" value="NISN" />
                            <x-text-input id="nisn" name="nisn" type="text" class="mt-1 block w-full" :value="old('nisn', $user->nisn)" placeholder="Contoh: 0051234567" required />
                        </div>

                        <div>
                            <x-input-label for="no_hp" value="No. WhatsApp / HP" />
                            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)" placeholder="Contoh: 081234567890" required />
                        </div>

                        <div>
                            <x-input-label for="nama_orang_tua" value="Nama Orang Tua / Wali" />
                            <x-text-input id="nama_orang_tua" name="nama_orang_tua" type="text" class="mt-1 block w-full" :value="old('nama_orang_tua', $user->nama_orang_tua)" required />
                        </div>

                        <div>
                            <x-input-label for="alamat" value="Alamat Lengkap Rumah" />
                            <textarea id="alamat" name="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Biodata') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Form Edit Profile Bawaan Breeze -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Form Ubah Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>