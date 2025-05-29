<!-- laporan_excel.blade.php -->
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensis as $absen)
        <tr>
            <td>{{ $absen->tanggal }}</td>
            <td>{{ $absen->jam }}</td>
            <td>{{ $absen->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>