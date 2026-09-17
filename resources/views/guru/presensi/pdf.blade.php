<!DOCTYPE html>
<html>
<head>
    <title>Rekapan Presensi Siswa PKL</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; text-transform: uppercase; }
        .meta-info { margin-bottom: 15px; font-size: 10px; }
        .meta-info td { border: none; padding: 2px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        table.data-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>REKAPAN PRESENSI SISWA PKL</h2>
    
    <!-- SUB-HEADER INFORMASI FILTER -->
    <table class="meta-info" width="100%">
        <tr>
            <td width="15%"><strong>Sekolah</strong></td>
            <td width="35%">: {{ $sekolahFilter ?? 'Semua Sekolah' }}</td>
            <td width="15%"><strong>Tanggal Cetak</strong></td>
            <td width="35%">: {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td><strong>Periode</strong></td>
            <td colspan="3">: 
                @php
                    $namaBulan = [
                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                    ];
                @endphp
                {{ isset($bulan) && $bulan ? ($namaBulan[$bulan] ?? $bulan) : 'Semua Bulan' }} 
                {{ $tahun ?? 'Semua Tahun' }}
            </td>
        </tr>
    </table>

    <!-- TABEL DATA PRESENSI -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="22%">Nama Siswa</th>
                <th width="20%">Asal Sekolah</th>
                <th width="22%">Email</th>
                <th width="8%">Hadir</th>
                <th width="8%">Terlambat</th>
                <th width="8%">Izin</th>
                <th width="8%">Sakit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $key => $siswa)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $siswa->name }}</td>
                    <td>{{ $siswa->asal_sekolah ?? '-' }}</td>
                    <td>{{ $siswa->email }}</td>
                    <td class="text-center">{{ $siswa->presensis->where('status', 'hadir')->count() }}</td>
                    <td class="text-center">{{ $siswa->presensis->where('status', 'terlambat')->count() }}</td>
                    <td class="text-center">{{ $siswa->presensis->where('status', 'izin')->count() }}</td>
                    <td class="text-center">{{ $siswa->presensis->where('status', 'sakit')->count() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data presensi siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>