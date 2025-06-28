<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Absensi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #ddd;
        }

        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            font-style: italic;
            font-size: 11px;
            color: #888;
            margin-top: 30px;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <h2>Rekapitulasi Kehadiran Karyawan</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Lokasi Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $a)
            <tr>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->karyawan->nik ?? '-' }}</td>
                <td>{{ $a->karyawan->nama_lengkap ?? '-' }}</td>
                <td>{{ $a->karyawan->jabatan ?? '-' }}</td>
                <td>{{ $a->jam_masuk ?? '-' }}</td>
                <td>{{ $a->jam_pulang ?? '-' }}</td>
                <td>
                    {{ $a->latitude_masuk && $a->longitude_masuk
                        ? $a->latitude_masuk . ', ' . $a->longitude_masuk
                        : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br><br>
    <div style="margin-top: 50px; text-align: right; font-size: 12px;">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Ditandatangani oleh,</p>
        <br><br>
        <strong style="border-top: 1px solid #000; display: inline-block; padding-top: 5px;">
            HRD / Admin Absensi
        </strong>
    </div>

    <div style="margin-top: 40px; font-size: 10px; color: gray; text-align: center;">
        Sistem Absensi Online — Dikembangkan oleh Mimi Lavenia Sinaga • Universitas Mercu Buana Menteng
    </div>


    <div class="footer">
        Dicetak secara otomatis pada {{ now()->format('d-m-Y H:i') }} | Dibuat oleh: <strong>Mimi Lavenia Sinaga</strong> - Developer Sistem Absensi
    </div>

</body>

</html>