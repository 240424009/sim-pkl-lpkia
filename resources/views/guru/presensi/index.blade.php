<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekapan Presensi Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Rekapan Kehadiran Siswa</h3>
                <a href="{{ route('guru.presensi.pdf') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded shadow transition">
        📄 Export PDF
    </a>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <th class="py-3 px-4">Nama Siswa</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4 text-center">Total Hadir</th>
                                <th class="py-3 px-4 text-center">Total Terlambat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($siswas as $siswa)
                                <tr>
                                    <td class="py-3 px-4 font-bold text-gray-800">{{ $siswa->name }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $siswa->email }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded font-bold">
                                            {{ $siswa->presensis->where('status', 'hadir')->count() }} Hari
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-1 rounded font-bold">
                                            {{ $siswa->presensis->where('status', 'terlambat')->count() }} Hari
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>