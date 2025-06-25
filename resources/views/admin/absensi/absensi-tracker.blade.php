<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Absensi Tracker - Sistem Absensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #2d3b55;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            margin: 5px 0;
            display: block;
            padding: 10px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: #3d4f74;
            text-decoration: none;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .top-navbar {
            height: 60px;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            width: calc(100% - 250px);
            top: 0;
            left: 250px;
            z-index: 1000;
        }

        .content-wrapper {
            margin-top: 80px;
        }

        .watermark {
            text-align: center;
            font-size: 0.8rem;
            margin-top: auto;
            color: #ccc;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo text-center">
            <img src="{{ asset('img/loho.png') }}" alt="Logo Sistem Absensi" style="max-width: 150px;">
        </div>
        <ul class="nav flex-column px-2">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#masterDataMenu" role="button" aria-expanded="false" aria-controls="masterDataMenu">
                    <i class="bi bi-archive-fill"></i> Master Data
                    <i class="bi bi-caret-down-fill float-end"></i>
                </a>
                <div class="collapse ps-3" id="masterDataMenu">
                    <a class="nav-link text-white" href="{{ route('admin.departemen') }}">
                        <i class="bi bi-building"></i> Data Departemen
                    </a>
                    <a class="nav-link text-white" href="{{ route('admin.dataKaryawan') }}">
                        <i class="bi bi-person-badge"></i> Data Karyawan
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.monitoring-presensi') }}" class="nav-link">
                    <i class="bi bi-clipboard-check"></i> Absensi Tracker
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.laporan.presensi') }}" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i> Laporan Absensi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.lokasi-kantor') }}" class="nav-link">
                    <i class="bi bi-geo-alt-fill"></i> Lokasi Kantor
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.pengaturan-akun') }}" class="nav-link">
                    <i class="bi bi-gear-fill"></i> Pengaturan Akun
                </a>
            </li>
            <li class="nav-item mt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-white" style="width: 100%; text-align: left;">
                        <i class="bi bi-box-arrow-right"></i> Log Out
                    </button>
                </form>
            </li>
        </ul>

        <div class="watermark">
            &copy; 2025 by Mimi Sinaga - Programmer
        </div>
    </div>

    <div class="main-content">
        <nav class="top-navbar">
            <div>Selamat Datang, Administrator</div>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </nav>

        <div class="content-wrapper">
            <h4>Absensi Tracker</h4>

            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    Form Absensi Kehadiran - {{ date('d M Y') }}
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.absensi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status Kehadiran</label>
                            <select name="keterangan" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                            </select>
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle-fill"></i> Simpan Absensi
                        </button>
                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-3" id="lokasi-status">
                Mendeteksi lokasi pengguna...
            </div>
        </div>
    </div>

    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                document.getElementById('latitude').value = pos.coords.latitude;
                document.getElementById('longitude').value = pos.coords.longitude;
                document.getElementById('lokasi-status').innerText = "Lokasi berhasil dideteksi.";
            }, function() {
                document.getElementById('lokasi-status').innerText = "Gagal mendeteksi lokasi.";
            });
        } else {
            document.getElementById('lokasi-status').innerText = "Browser tidak mendukung geolocation.";
        }
    </script>
</body>

</html>