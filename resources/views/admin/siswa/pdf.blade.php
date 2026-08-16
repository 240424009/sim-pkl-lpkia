<!DOCTYPE html>
<html>
<head>
    <title>Rekap Data Siswa PKL LPKIA</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; font-size: 10px; color: #555; }
    </style>
</head>
<body>
    <h2>REKAPITULASI DATA SISWA PKL LPKIA</h2>
    <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>NISN</th>
                <th>Asal Sekolah</th>
                <th>Departemen LPKIA</th>
                <th>No. HP</th>
                <th>Nama Orang Tua</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $index => $siswa)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $siswa->name }}</td>
                <td>{{ $siswa->email }}</td>
                <td>{{ $siswa->nisn ?? '-' }}</td>
                <td>{{ $siswa->asal_sekolah ?? '-' }}</td>
                <td>{{ $siswa->departemen_lpkia ?? '-' }}</td>
                <td>{{ $siswa->no_hp ?? '-' }}</td>
                <td>{{ $siswa->nama_orang_tua ?? '-' }}</td>
                <td style="text-align: center;">
                    @if($siswa->foto)
                        <img src="{{ public_path('storage/' . $siswa->foto) }}" style="width: 40px; height: 50px; object-fit: cover;">
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>