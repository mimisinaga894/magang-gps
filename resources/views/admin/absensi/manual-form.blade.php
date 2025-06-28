<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Absensi Manual</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f7;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        h4 {
            font-weight: bold;
            color: #343a40;
            border-left: 5px solid #0d6efd;
            padding-left: 10px;
        }

        label {
            font-weight: 500;
            color: #495057;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4">
            <h4 class="mb-4">Form Absensi Manual</h4>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.absensi.manual.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_karyawan">Nama Karyawan</label>
                        <input type="text" list="list_karyawan" id="nama_karyawan" class="form-control"
                            placeholder="Ketik nama..." required>
                        <datalist id="list_karyawan">
                            @foreach($karyawans as $k)
                            <option value="{{ $k->nama_lengkap }}"
                                data-nik="{{ $k->nik }}"
                                data-jabatan="{{ $k->jabatan }}"
                                data-departemen="{{ $k->departemen->nama }}">
                                @endforeach
                        </datalist>
                    </div>

                    <div class="col-md-6">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" id="nik" class="form-control" readonly required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label for="departemen">Departemen</label>
                        <input type="text" name="departemen" id="departemen" class="form-control" readonly required>
                    </div>
                </div>

                <input type="hidden" name="nama_lengkap" id="nama_lengkap_hidden">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="keterangan">Status Kehadiran</label>
                        <select name="keterangan" id="keterangan" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-control" required>
                    </div>
                </div>

                <div class="action-buttons mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Simpan Absensi Manual
                    </button>

                    <a href="{{ route('admin.absensi-tracker') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const karyawanData = [
            @foreach($karyawans as $k) {
                nama_lengkap: "{{ $k->nama_lengkap }}",
                nik: "{{ $k->nik }}",
                jabatan: "{{ $k->jabatan }}",
                departemen: {
                    nama: "{{ $k->departemen->nama }}"
                }
            },
            @endforeach

        ];

        const namaInput = document.getElementById('nama_karyawan');

        function isiOtomatis() {
            const nama = namaInput.value;
            const karyawan = karyawanData.find(k => k.nama_lengkap === nama);

            if (karyawan) {
                document.getElementById('nik').value = karyawan.nik;
                document.getElementById('jabatan').value = karyawan.jabatan;
                document.getElementById('departemen').value = karyawan.departemen.nama;
                document.getElementById('nama_lengkap_hidden').value = karyawan.nama_lengkap;
            } else {
                document.getElementById('nik').value = '';
                document.getElementById('jabatan').value = '';
                document.getElementById('departemen').value = '';
                document.getElementById('nama_lengkap_hidden').value = '';
            }
        }

        namaInput.addEventListener('input', isiOtomatis);
        namaInput.addEventListener('change', isiOtomatis);
        namaInput.addEventListener('blur', isiOtomatis);
    </script>

</body>

</html>