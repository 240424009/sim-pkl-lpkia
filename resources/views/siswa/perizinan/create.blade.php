<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Perizinan / Ketidak-hadiran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <form action="{{ route('siswa.perizinan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kategori Izin</label>
                        <select name="kategori" class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500" required>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin / Acara Keluarga</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="w-full rounded-lg border-gray-300 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="w-full rounded-lg border-gray-300 text-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Alasan Ketidak-hadiran</label>
                        <textarea name="alasan" rows="3" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Tuliskan alasan jelas..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Upload Surat Dokter / Surat Izin (Opsional, PDF/Foto Max 2MB)</label>
                        <input type="file" name="bukti_dokumen" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('siswa.perizinan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-xs rounded-lg font-bold">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-xs rounded-lg font-bold hover:bg-indigo-700">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>