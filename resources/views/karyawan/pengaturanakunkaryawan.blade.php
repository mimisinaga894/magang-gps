<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pengaturan Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            width: 250px;
            transition: width 0.3s ease;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .sidebar .logo img {
            width: 150px;
            height: auto;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #007bff;
            text-decoration: none;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            min-height: 100vh;
            background-color: #ffffff;
            transition: margin-left 0.3s ease;
        }

        .top-navbar {
            background-color: #007bff;
            color: white;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            width: calc(100% - 250px);
            top: 0;
            left: 250px;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .top-navbar .welcome-text {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .top-navbar .user-info {
            display: flex;
            align-items: center;
        }

        .top-navbar .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #ffffff;
            padding: 30px;
            margin-top: 90px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }

            .sidebar.show {
                width: 250px;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .top-navbar {
                left: 0;
                width: 100%;
            }

            .form-control {
                padding: 10px;
            }
        }
    </style>
</head>

<body>


    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('img/loho.png') }}" alt="Logo Sistem Absensi">
        </div>
        <a href="{{ route('karyawan.dashboard') }}" class="nav-link active"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="{{ route('karyawan.lokasi-kantor') }}" class="nav-link"><i class="bi bi-geo-alt"></i> Lokasi Kantor</a>
        <a href="{{ route('karyawan.profile') }}" class="nav-link"><i class="bi bi-person"></i> Pengaturan Akun</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link nav-link text-white" style="width: 100%; text-align: left;">
                <i class="bi bi-box-arrow-right"></i> Log Out
            </button>
        </form>
        <div class="watermark">
            &copy; 2025 by Mimi Sinaga - Programmer
        </div>
    </div>


    <div class="main-content">

        <div class="top-navbar d-flex justify-content-between align-items-center bg-primary text-white shadow-sm py-3 px-4">
            <!-- Welcome Text -->
            <div class="welcome-text fs-5 fw-bold">
                Selamat Datang, {{ Auth::user()->name }}
            </div>

            <!-- User Info -->
            <div class="user-info d-flex align-items-center gap-2">
                <!-- User Avatar -->
                <img src="{{ asset('img/logo.png') }}" alt="Avatar" class="rounded-circle border border-2 border-light" width="40" height="40">

                <!-- User Name -->
                <span class="d-none d-sm-inline-block fw-semibold">{{ Auth::user()->name }}</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-circle"></i> Pengaturan Akun
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>


                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    </script>
</body>

</html>