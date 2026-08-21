<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Perizinan Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center pb-4 mb-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700">Kelola Pengajuan Perizinan</h3>
                    <form method="GET" action="{{ route('admin.perizinan.index') }}" class="flex items-center gap-2">
                        <select name="status" class="text-xs rounded-lg border-gray-300 py-2">
                            <option value="">-- Semua Status --</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white text-xs px-3 py-2 rounded-lg font-bold">Filter</button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b text-gray-700 uppercase text-xs">
                                <th class="p-3">Nama Siswa</th>
                                <th class="p-3">Kategori</th>
                                <th class="p-3">Periode</th>
                                <th class="p-3">Alasan</th>
                                <th class="p-3">Bukti</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-center">Aksi Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($perizinans as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-bold text-gray-800">
                                        {{ $item->user->name ?? 'Siswa Dihapus' }}
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $item->kategori == 'Sakit' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-xs text-gray-600">
                                        {{ date('d M Y', strtotime($item->tanggal_mulai)) }} s/d {{ date('d M Y', strtotime($item->tanggal_selesai)) }}
                                    </td>
                                    <td class="p-3 text-gray-700 text-xs">{{ $item->alasan }}</td>
                                    <td class="p-3">
                                        @if($item->bukti_dokumen)
                                            <a href="{{ asset('storage/' . $item->bukti_dokumen) }}" target="_blank" class="text-indigo-600 underline text-xs font-bold">
                                                📄 Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($item->status == 'Pending')
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800">⏳ Pending</span>
                                        @elseif($item->status == 'Disetujui')
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">✅ Disetujui</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-800">❌ Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        @if($item->status == 'Pending')
                                            <div class="flex justify-center gap-1">
                                                <!-- Form Setujui -->
                                                <form action="{{ route('admin.perizinan.update-status', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Disetujui">
                                                    <button type="submit" onclick="return confirm('Setujui izin ini?')" class="px-2.5 py-1.5 bg-green-600 hover:bg-green-700 text-white font-bold text-xs rounded shadow-sm">
                                                        ✅ Setujui
                                                    </button>
                                                </form>

                                                <!-- Form Tolak -->
                                                <form action="{{ route('admin.perizinan.update-status', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" onclick="return confirm('Tolak izin ini?')" class="px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded shadow-sm">
                                                        ❌ Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 font-semibold">Selesai Diverifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-gray-500">Belum ada data pengajuan perizinan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>