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
                
                <!-- HEADER & FILTER PERIODE PER BULAN -->
                <div class="flex flex-col md:flex-row md:items-center justify-between pb-4 mb-4 border-b border-gray-100 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Jurnal Masuk</h3>
                        <p class="text-xs text-gray-500">Filter data jurnal berdasarkan bulan dan tahun kegiatan.</p>
                    </div>

                    <!-- FORM FILTER -->
                    <form method="GET" action="{{ route('admin.jurnal.index') }}" class="flex items-center gap-2 flex-wrap">
                        <!-- Select Bulan -->
                        <select name="bulan" class="text-xs rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 py-2">
                            <option value="">-- Semua Bulan --</option>
                            @php
                                $namaBulan = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                                    '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
                                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                                $selectedBulan = $bulanSelected ?? request('bulan');
                                $selectedTahun = $tahunSelected ?? request('tahun', date('Y'));
                            @endphp
                            @foreach($namaBulan as $key => $bulan)
                                <option value="{{ $key }}" {{ ($selectedBulan == $key) ? 'selected' : '' }}>
                                    {{ $bulan }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Select Tahun -->
                        <select name="tahun" class="text-xs rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 py-2">
                            @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                <option value="{{ $y }}" {{ ($selectedTahun == $y) ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>

                        <!-- Tombol Filter -->
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-2 rounded-lg font-bold transition flex items-center gap-1 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.447.894l-4 2A1 1 0 017 21v-7.586L2.293 6.707A1 1 0 012 6V4z"/></svg>
                            Filter
                        </button>

                        @if(request('bulan'))
                            <a href="{{ route('admin.jurnal.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs px-3 py-2 rounded-lg font-medium transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- TABEL DATA -->
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
                                    <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada data jurnal pada periode bulan yang dipilih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION LINK -->
                <div class="mt-4">
                    {{ $jurnals->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>