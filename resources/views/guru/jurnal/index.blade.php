<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Jurnal Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Daftar Jurnal Siswa</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Nama Siswa</th>
                                <th class="py-3 px-4">Kegiatan</th>
                                <th class="py-3 px-4">Status Approval</th>
                                <th class="py-3 px-4">Rating Ti Pembimbing</th>
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
                                    <td class="py-3 px-4 font-bold text-indigo-600">
                                        {{ $row->rating ? $row->rating . ' / 5 ⭐' : 'Belum Dinilai' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada jurnal kegiatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>