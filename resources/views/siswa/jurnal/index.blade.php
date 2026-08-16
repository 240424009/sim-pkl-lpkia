<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jurnal Kegiatan Harian PKL') }}
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

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Isi Jurnal -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Isi Jurnal Hari Ini</h3>
                
                <form action="{{ route('siswa.jurnal.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Pekerjaan / Kegiatan</label>
                        <textarea name="deskripsi_pekerjaan" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tuliskan kegiatan yang Anda lakukan hari ini..." required></textarea>
                    </div>

                    <!-- Tombol Simpan Jurnal -->
                    <div class="pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition">
                            💾 Simpan Jurnal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Riwayat Jurnal -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Riwayat Jurnal Kegiatan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Deskripsi Kegiatan</th>
                                <th class="py-3 px-4">Status Approval</th>
                                <th class="py-3 px-4">Rating Ti Pembimbing</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($jurnals as $row)
                                <tr>
                                    <td class="py-3 px-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                    <td class="py-3 px-4">{{ $row->deskripsi_pekerjaan }}</td>
                                    <td class="py-3 px-4">
                                        @if($row->status_approval === 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold">Disetujui</span>
                                        @elseif($row->status_approval === 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-bold">Ditolak</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-bold">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $row->rating ? $row->rating . ' / 5 ⭐' : 'Belum Dinilai' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">Belum ada jurnal kegiatan yang diisi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>