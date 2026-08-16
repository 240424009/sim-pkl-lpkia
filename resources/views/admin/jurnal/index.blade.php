<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Jurnal Kegiatan Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Daftar Jurnal Masuk</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Nama Siswa</th>
                                <th class="py-3 px-4">Kegiatan</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Aksi & Penilaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($jurnals as $row)
                                <tr>
                                    <td class="py-3 px-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                                    <td class="py-3 px-4 font-bold text-gray-800">{{ $row->user->name ?? 'Siswa' }}</td>
                                    <td class="py-3 px-4">{{ $row->deskripsi_pekerjaan }}</td>
                                    <td class="py-3 px-4">
                                        @if($row->status_approval === 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded font-bold">Disetujui</span>
                                        @elseif($row->status_approval === 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded font-bold">Ditolak</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-1 rounded font-bold">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 min-w-[300px]">
                                        <form action="{{ route('admin.jurnal.update', $row->id) }}" method="POST" class="space-y-2">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="flex items-center gap-2">
                                                <!-- Select Status -->
                                                <select name="status_approval" class="text-xs rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                                    <option value="approved" {{ $row->status_approval == 'approved' ? 'selected' : '' }}>Setujui</option>
                                                    <option value="rejected" {{ $row->status_approval == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                                </select>

                                                <!-- Select Rating -->
                                                <select name="rating" class="text-xs rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                                                    <option value="">-- Rating --</option>
                                                    @for($i=1; $i<=5; $i++)
                                                        <option value="{{ $i }}" {{ $row->rating == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- Input Catatan Pembimbing -->
                                            <input type="text" name="catatan_pembimbing" value="{{ $row->catatan_pembimbing }}" placeholder="Catatan pembimbing (opsional)..." class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">

                                            <!-- Tombol Simpan -->
                                            <button type="submit" class="w-full py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded shadow-sm transition">
                                                💾 Simpan Penilaian
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada jurnal yang dikirim oleh siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>