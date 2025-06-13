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
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            color: #f8f9fa;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
        }

        .sidebar .nav-link:hover {
            background-color: #3d4f74;
            border-radius: 4px;
        }

        .sidebar .watermark {
            font-size: 0.75rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 10px;
            user-select: none;
            pointer-events: none;
            font-style: italic;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .top-navbar {
            height: 60px;
            background-color: rgb(109, 179, 253);
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
        }

        .top-navbar .welcome-text {
            margin-right: 10px;
            font-weight: 600;
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
            pointer-events: none;
            z-index: 1001;
        }

        .content-wrapper {
            margin-top: 70px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="logo">Sistem Absensi</div>
        <nav class="nav flex-column px-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.dataKaryawan') }}" class="nav-link">
                <i class="bi bi-people-fill"></i> Data Karyawan
            </a>
            <a href="{{ route('admin.dataDepartemen') }}" class="nav-link">
                <i class="bi bi-building"></i> Data Departemen
            </a>
            <a href="{{ route('admin.pengaturan-akun') }}" class="nav-link active" style="background-color: #3d4f74; border-radius: 4px;">
                <i class="bi bi-gear-fill"></i> Pengaturan Akun
            </a>
        </nav>
        <div class="watermark">© 2025 Sistem Absensi</div>
    </div>

    <div class="top-navbar">
        <span class="welcome-text">Selamat datang, {{ Auth::user()->name }}</span>
        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm me-2">Edit Profile</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </div>

    <main class="main-content">
        <div class="content-wrapper">
            <h2>Pengaturan Akun</h2>
            <p>Atur detail akun Anda di halaman ini.</p>

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
                    <label for="password" class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                    <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </main>

    <footer class="watermark-footer">
        Sistem Absensi - &copy; 2025
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>