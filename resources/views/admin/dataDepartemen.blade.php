<div class="container">
    <h1>Data Departemen</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>kode</th>
                <th>Nama Departemen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departemen as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->kode}}</td>
                <td>{{ $item->nama}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>