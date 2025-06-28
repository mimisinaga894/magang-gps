<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Kerja</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }

        select,
        input[type="date"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-4 text-primary">➕ Tambah Jadwal Kerja</h3>

                <form action="{{ route('jadwal.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="shift" class="form-label">Shift</label>
                        <select name="shift" id="shift" class="form-select" required>
                            <option value="">-- Pilih Shift --</option>
                            <option value="pagi">Pagi</option>
                            <option value="siang">Siang</option>
                            <option value="malam">Malam</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-success">💾 Simpan</button>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary ms-2">❌ Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>