<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Perizinan / Ketidak-hadiran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center pb-4 mb-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700">Daftar Pengajuan Izin / Sakit</h3>
                    <a href="{{ route('siswa.perizinan.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-lg shadow transition">
                        + Ajukan Perizinan
                    </a>
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
                                <th class="p-3">Kategori</th>
                                <th class="p-3">Tanggal Periode</th>
                                <th class="p-3">Alasan</th>
                                <th class="p-3">Bukti</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Catatan Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($perizinans as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-bold">
                                        <span class="px-2.5 py-1 rounded-full text-xs {{ $item->kategori == 'Sakit' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-xs text-gray-600">
                                        {{ date('d M Y', strtotime($item->tanggal_mulai)) }} s/d {{ date('d M Y', strtotime($item->tanggal_selesai)) }}
                                    </td>
                                    <td class="p-3 text-gray-700">{{ $item->alasan }}</td>
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
                                    <td class="p-3 text-xs text-gray-500">{{ $item->catatan_admin ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500">Belum ada riwayat pengajuan perizinan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>