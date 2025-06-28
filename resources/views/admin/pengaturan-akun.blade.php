<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pengaturan Akun</title>

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
                    <a href="{{ route('admin.absensi-tracker') }}" class="nav-link">
                        <i class="bi bi-clipboard-check"></i> Absensi Tracker
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jadwal.index') }}" class="nav-link">
                        <i class="bi bi-file-earmark-text"></i> Jadwal Kerja
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
                </li>
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
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

    <div class="top-navbar">
        <span class="welcome-text">👋 Selamat datang, {{ Auth::user()->name }}</span>
        <a href="{{ route('admin.pengaturan-akun') }}" class="btn btn-outline-light btn-sm me-2">
            <i class="bi bi-person-circle"></i> Edit Profile
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <main class="main-content">
        <div class="content-wrapper bg-white shadow rounded p-4">
            <h3 class="mb-3">🔧 Pengaturan Akun</h3>
            <p class="text-muted">Perbarui informasi akun Anda dengan aman di sini.</p>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', Auth::user()->name) }}" required />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru <small class="text-muted">(Biarkan kosong jika tidak diubah)</small></label>
                    <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
            </form>
        </div>
    </main>

    <footer class="watermark-footer">
        Sistem Absensi - &copy; 2025
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>