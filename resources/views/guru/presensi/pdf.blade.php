<!DOCTYPE html>
<html>
<head>
    <title>Rekapan Presensi Siswa PKL</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>REKAPAN PRESENSI SISWA PKL</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>Total Hadir</th>
                <th>Total Terlambat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $key => $siswa)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $siswa->name }}</td>
                    <td>{{ $siswa->email }}</td>
                    <td class="text-center">{{ $siswa->presensis->where('status', 'hadir')->count() }} Hari</td>
                    <td class="text-center">{{ $siswa->presensis->where('status', 'terlambat')->count() }} Hari</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>