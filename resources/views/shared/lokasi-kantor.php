<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lokasi Kantor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />

    <style>
        body {
            overflow-x: hidden;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .sidebar {
            background-color: #2d3b55;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            width: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .logo {
            font-size: 1.6rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #3d4f74;
            border-radius: 6px;
        }

        .sidebar .watermark {
            font-size: 0.75rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 10px;
            user-select: none;
            font-style: italic;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .top-navbar {
            height: 60px;
            background-color: #6db3fd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 20px;
            position: fixed;
            width: calc(100% - 250px);
            top: 0;
            left: 250px;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-navbar .welcome-text {
            margin-right: auto;
            font-weight: 600;
            color: white;
        }

        .content-wrapper {
            margin-top: 80px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-control {
            border-radius: 6px;
        }

        .btn-primary {
            background-color: #2d3b55;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1f2a3e;
        }

        .btn-outline-primary {
            border-radius: 30px;
            padding: 8px 20px;
        }

        .card-title i {
            vertical-align: middle;
            margin-right: 8px;
        }

        .card {
            background: #ffffff;
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        footer.watermark-footer {
            position: fixed;
            bottom: 5px;
            left: 250px;
            width: calc(100% - 250px);
            text-align: center;
            font-size: 0.75rem;
            color: rgba(0, 0, 0, 0.3);
            font-style: italic;
            user-select: none;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div>
            <div class="logo text-center mb-4">
                <img src="{{ asset('img/loho.png') }}" alt="Logo Sistem Absensi"
                    style="max-width: 150px; height: auto;">
            </div>

            <ul class="nav flex-column px-2">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#masterDataMenu" role="button"
                        aria-expanded="false" aria-controls="masterDataMenu">
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
                    <a href="{{ route('admin.lokasi-kantor') }}" class="nav-link active">
                        <i class="bi bi-geo-alt-fill"></i> Lokasi Kantor
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pengaturan-akun') }}" class="nav-link">
                        <i class="bi bi-gear-fill"></i> Pengaturan Akun
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-link nav-link text-white"
                            style="width: 100%; text-align: left;">
                            <i class="bi bi-box-arrow-right"></i> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="watermark">
            &copy; 2025 by Mimi Sinaga - Programmer
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <div class="main-content">
        <nav class="top-navbar">
            <div class="welcome-text">Selamat Datang, Administrator</div>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </nav>

        <div class="content-wrapper">
            <div class="container mt-5">
                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body px-5 py-4">
                        <h3 class="card-title text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-geo-alt-fill text-danger"></i> Lokasi Kantor Kami
                        </h3>
                        <br>

                        <div class="mb-5 text-center">
                            <h5 class="fw-semibold"><i class="bi bi-building text-primary"></i> Alamat</h5>
                            <p class="mb-0">Jl. Merdeka No. 123</p>
                            <p class="mb-0">Kecamatan Menteng, Jakarta Pusat</p>
                            <p>DKI Jakarta, Indonesia</p>
                        </div>

                        <div class="mb-5 text-center">
                            <h5 class="fw-semibold"><i class="bi bi-map-fill text-success"></i> Lihat di Peta</h5>
                            <div class="rounded overflow-hidden shadow-sm" style="border: 2px solid #ccc;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d991.5974963410468!2d106.82715339999999!3d-6.208763!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e8f4f63b37%3A0x499c0a36427fd1d7!2sMonas%2C%20Jakarta!5e0!3m2!1sid!2sid!4v1718280912345"
                                    width="100%" height="300" style="border:0;" allowfullscreen loading="lazy">
                                </iframe>
                            </div>
                        </div>

                        <p class="text-center text-muted mb-5" style="font-size: 1.1rem;">
                            Berikut adalah informasi alamat lengkap kantor dan lokasi kami di peta.
                        </p>

                        <div class="text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>