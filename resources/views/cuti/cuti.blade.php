<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* ... tetap pakai style yang sudah ada ... */
        body {
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #2d3b55;
            color: #f8f9fa;
            height: 100vh;
            padding: 20px 15px;
            position: fixed;
            width: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .logo {
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            user-select: none;
        }

        .sidebar .nav-link {
            color: #f8f9fa;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #3d4f74;
            color: #fff;
        }

        .sidebar .watermark {
            font-size: 0.75rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.25);
            margin-bottom: 10px;
            user-select: none;
            pointer-events: none;
            font-style: italic;
        }

        .main-content {
            margin-left: 250px;
            padding: 80px 30px 30px 30px;
            min-height: 100vh;
            background-color: #fff;
            box-shadow: inset 0 0 5px rgb(0 0 0 / 0.05);
        }

        .top-navbar {
            height: 60px;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 25px;
            position: fixed;
            width: calc(100% - 250px);
            top: 0;
            left: 250px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        }

        .top-navbar .welcome-text {
            margin-right: 15px;
            font-weight: 600;
            font-size: 1rem;
        }

        footer.watermark-footer {
            position: fixed;
            bottom: 5px;
            left: 250px;
            width: calc(100% - 250px);
            text-align: center;
            font-size: 0.75rem;
            color: rgba(0, 0, 0, 0.25);
            font-style: italic;
            user-select: none;
            pointer-events: none;
            z-index: 1001;
        }

        .card-header {
            font-weight: 600;
            background-color: #2d3b55;
            color: white;
            font-size: 1.25rem;
        }

        .btn {
            min-width: 150px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 10px 0;
                flex-direction: row;
                justify-content: space-around;
            }

            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .top-navbar {
                width: 100%;
                left: 0;
                justify-content: center;
            }

            footer.watermark-footer {
                left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="sidebar">
        <img src="{{ asset('img/loho.png') }}" alt="Logo" class="logo-img" />
        <div>
            <a href="#" class="nav-link active">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="nav-link">
                <i class="bi bi-gear-fill"></i> Profile
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-link">
                <i class="bi bi-gear-fill"></i> Pengaturan Akun
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link text-white px-0" style="width: 100%; text-align: left;">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </button>
            </form>
        </div>
        <div class="watermark">© 2025 Mimi Sinaga</div>
    </nav>

    <header class="top-navbar">
        <div class="welcome-text">Selamat datang, {{ Auth::user()->name }}!</div>
    </header>
    @extends('layouts.app')

    @section('content')
    <div class="container mt-4">
        <h2>Form Pengajuan Cuti</h2>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Menampilkan error validasi --}}
        @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form cuti --}}
        <form method="POST" action="{{ route('cuti.store') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" required value="{{ old('tanggal_mulai') }}">
            </div>

            <div class="form-group mb-3">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" required value="{{ old('tanggal_selesai') }}">
            </div>

            <div class="form-group mb-3">
                <label for="jenis_cuti">Jenis Cuti</label>
                <select name="jenis_cuti" class="form-control" required>
                    <option value="">-- Pilih Jenis Cuti --</option>
                    <option value="Cuti Tahunan" {{ old('jenis_cuti') == 'Cuti Tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                    <option value="Cuti Sakit" {{ old('jenis_cuti') == 'Cuti Sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                    <option value="Cuti Melahirkan" {{ old('jenis_cuti') == 'Cuti Melahirkan' ? 'selected' : '' }}>Cuti Melahirkan</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="alasan">Alasan (Opsional)</label>
                <textarea name="alasan" class="form-control" rows="3">{{ old('alasan') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Ajukan Cuti</button>
        </form>
    </div>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Dashboard Karyawan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            body {
                overflow-x: hidden;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f9fa;
            }

            .sidebar {
                background-color: #2d3b55;
                color: #f8f9fa;
                height: 100vh;
                padding: 20px 15px;
                position: fixed;
                width: 250px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .sidebar .logo {
                font-size: 1.8rem;
                font-weight: 700;
                text-align: center;
                margin-bottom: 2rem;
                user-select: none;
            }

            .sidebar .nav-link {
                color: #f8f9fa;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 12px;
                border-radius: 5px;
                transition: background-color 0.3s ease;
                text-decoration: none;
            }

            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                background-color: #3d4f74;
                color: #fff;
            }

            .sidebar .watermark {
                font-size: 0.75rem;
                text-align: center;
                color: rgba(255, 255, 255, 0.25);
                margin-bottom: 10px;
                user-select: none;
                pointer-events: none;
                font-style: italic;
            }

            .main-content {
                margin-left: 250px;
                padding: 80px 30px 30px 30px;
                min-height: 100vh;
                background-color: #fff;
                box-shadow: inset 0 0 5px rgb(0 0 0 / 0.05);
            }

            .top-navbar {
                height: 60px;
                background-color: #007bff;
                color: white;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                padding: 0 25px;
                position: fixed;
                width: calc(100% - 250px);
                top: 0;
                left: 250px;
                z-index: 1000;
                box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            }

            .top-navbar .welcome-text {
                margin-right: 15px;
                font-weight: 600;
                font-size: 1rem;
            }

            footer.watermark-footer {
                position: fixed;
                bottom: 5px;
                left: 250px;
                width: calc(100% - 250px);
                text-align: center;
                font-size: 0.75rem;
                color: rgba(0, 0, 0, 0.25);
                font-style: italic;
                user-select: none;
                pointer-events: none;
                z-index: 1001;
            }

            .card-header {
                font-weight: 600;
                background-color: #2d3b55;
                color: white;
                font-size: 1.25rem;
            }

            .btn {
                min-width: 150px;
            }

            @media (max-width: 768px) {
                .sidebar {
                    position: relative;
                    width: 100%;
                    height: auto;
                    padding: 10px 0;
                    flex-direction: row;
                    justify-content: space-around;
                }

                .main-content {
                    margin-left: 0;
                    padding: 20px 15px;
                }

                .top-navbar {
                    width: 100%;
                    left: 0;
                    justify-content: center;
                }

                footer.watermark-footer {
                    left: 0;
                    width: 100%;
                }
            }
        </style>
    </head>

    <body>
        <nav class="sidebar">
            <div class="logo">GPS</div>
            <div>
                <a href="#" class="nav-link active">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="bi bi-gear-fill"></i> Profile
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="bi bi-gear-fill"></i> Pengaturan Akun
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-white px-0" style="width: 100%; text-align: left;">
                        <i class="bi bi-box-arrow-right"></i> Log Out
                    </button>
                </form>
            </div>
            <div class="watermark">© 2025 Mimi Sinaga</div>
        </nav>

        <header class="top-navbar">
            <div class="welcome-text">Selamat datang, {{ Auth::user()->name }}!</div>
        </header>

        <div class="main-content">
            <div class="container mt-4">
                <h2>Form Pengajuan Cuti</h2>


                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif


                @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <form method="POST" action="{{ route('cuti.store') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required value="{{ old('tanggal_mulai') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required value="{{ old('tanggal_selesai') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_cuti">Jenis Cuti</label>
                        <select name="jenis_cuti" class="form-control" required>
                            <option value="">-- Pilih Jenis Cuti --</option>
                            <option value="Cuti Tahunan" {{ old('jenis_cuti') == 'Cuti Tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                            <option value="Cuti Sakit" {{ old('jenis_cuti') == 'Cuti Sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                            <option value="Cuti Melahirkan" {{ old('jenis_cuti') == 'Cuti Melahirkan' ? 'selected' : '' }}>Cuti Melahirkan</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="alasan">Alasan (Opsional)</label>
                        <textarea name="alasan" class="form-control" rows="3">{{ old('alasan') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Ajukan Cuti</button>
                </form>
            </div>
        </div>

        <footer class="watermark-footer">© 2025 Mimi Sinaga</footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>