<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - Sistem Absensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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

        .table th,
        .table td {
            vertical-align: middle;
        }

        .modal-box {
            padding: 20px;
        }

        .modal-box input {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            font-size: 0.75rem;
            color: rgba(0, 0, 0, 0.3);
            font-style: italic;
            margin-top: 50px;
        }

        #editModal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
        }

        #editModal .modal-box {
            background: white;
            max-width: 500px;
            padding: 30px;
            border-radius: 8px;
        }

        .btn-icon {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .watermark {
            text-align: center;
            font-size: 0.8rem;
            margin-top: auto;
            color: #ccc;
            font-style: italic;
        }

        .container-fluid,
        main {
            padding-top: 80px;
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

        <div class="row align-items-center mb-3" style="margin-top: 100px;">

            <div class="row mb-4">
                <div class="col-md-6 col-12 mb-2 mb-md-0">
                    <a href="{{ route('admin.absensi.manual-form') }}" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Absensi Manual
                    </a>
                </div>
                <div class="col-md-6 col-12 text-md-end">
                    <div class="d-inline-flex gap-2">
                        <a href="{{ route('admin.absensi.export.excel') }}" class="btn btn-outline-success shadow-sm px-3">
                            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.absensi.export.pdf') }}" class="btn btn-outline-danger shadow-sm px-3">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                        </a>

                    </div>
                </div>
            </div>

        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">Rekap Absensi</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Lokasi Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensiHariIni as $item)
                        <tr>
                            <td>{{ $item->tanggal_presensi }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->jam_masuk ?? '-' }}</td>
                            <td>{{ $item->jam_keluar ?? '-' }}</td>
                            <td>{{ $item->lokasi_masuk ?? '-' }}</td>
                        </tr>
                        @empty
                        <form method="GET" action="{{ route('admin.absensi-tracker') }}" class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Filter Berdasarkan</label>
                                <select name="periode" class="form-select" onchange="this.form.submit()">
                                    <option value="hari" {{ request('periode') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="minggu" {{ request('periode') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="bulan" {{ request('periode') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="tahun" {{ request('periode') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                                </select>
                            </div>
                        </form>
                        <br>
                        <br>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data absensi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>


        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-secondary text-white">Filter Absensi</div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.absensi-tracker') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="karyawan_id" class="form-label">Nama Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select">
                            <option value="">-- Semua Karyawan --</option>
                            @foreach($karyawans as $k)
                            <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_lengkap }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            <option value="">-- Bulan --</option>
                            @foreach(range(1,12) as $b)
                            <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" name="tahun" id="tahun" value="{{ request('tahun') ?? date('Y') }}" class="form-control">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-success text-white">Statistik Kehadiran</div>
            <div class="card-body">
                <div class="row text-center mb-4">
                    <div class="col">
                        <h6>Hadir</h6>
                        <p class="fs-4 text-success fw-bold">{{ $statistik['hadir'] }}</p>
                    </div>
                    <div class="col">
                        <h6>Sakit</h6>
                        <p class="fs-4 text-warning fw-bold">{{ $statistik['sakit'] }}</p>
                    </div>
                    <div class="col">
                        <h6>Izin</h6>
                        <p class="fs-4 text-info fw-bold">{{ $statistik['izin'] }}</p>
                    </div>
                </div>
                <canvas id="absensiChart" height="120"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('absensiChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Hadir', 'Sakit', 'Izin'],
                        datasets: [{
                            data: [{
                                    {
                                        (int) $statistik['hadir']
                                    }
                                },
                                {
                                    {
                                        (int) $statistik['sakit']
                                    }
                                },
                                {
                                    {
                                        (int) $statistik['izin']
                                    }
                                }
                            ],
                            backgroundColor: ['#198754', '#ffc107', '#0dcaf0'],
                            borderColor: ['#ffffff'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
        </script>