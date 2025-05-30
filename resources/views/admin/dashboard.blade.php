<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - Sistem Absensi</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet" />
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
            background-color:rgb(109, 179, 253);
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

<script>
    const labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    const hadirData = [10, 12, 9, 15, 14, 8, 7];
    const sakitData = [1, 0, 2, 1, 0, 0, 0];
    const izinData = [0, 1, 0, 0, 1, 1, 0];

    const data = {
        labels: labels,
        datasets: [{
                label: 'Hadir',
                data: hadirData,
                borderColor: 'green',
                backgroundColor: 'rgba(0, 128, 0, 0.2)',
                fill: true,
                tension: 0.3
            },
            {
                label: 'Sakit',
                data: sakitData,
                borderColor: 'red',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                fill: true,
                tension: 0.3
            },
            {
                label: 'Izin',
                data: izinData,
                borderColor: 'orange',
                backgroundColor: 'rgba(255, 165, 0, 0.2)',
                fill: true,
                tension: 0.3
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Absensi Mingguan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const ctx = document.getElementById('weeklyAbsensiChart').getContext('2d');
    new Chart(ctx, config);
</script>


<body>
    <div class="sidebar">
        <div>
            <div class="logo text-center mb-4">
                <img src="{{ asset('img/loho.png') }}" alt="Logo Sistem Absensi" style="max-width: 150px; height: auto;">
            </div>
            <ul class="nav flex-column px-2">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dataKaryawan') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i> Data Karyawan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dataDepartemen') }}" class="nav-link">
                        <i class="bi bi-building"></i> Data Departemen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.departemen') }}" class="nav-link">
                        <i class="bi bi-archive-fill"></i> Master Data
                    </a>
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
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-white p-0" style="width: 100%; text-align: left;">
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

    <div class="main-content">
        <nav class="top-navbar">
            <div class="welcome-text">Selamat Datang, Administrator</div>
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        </nav>

        <div class="content-wrapper">
            <h1 class="mb-4">Dashboard Admin</h1>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('register') }}" class="btn btn-primary">Tambah Pengguna</a>
            </div>

            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h2>Data Absensi Departemen Hari Ini ({{ \Carbon\Carbon::today()->format('d M Y') }})</h2>

            <table class="table table-bordered mb-5">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Departemen</th>
                        <th>Jumlah Karyawan</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departemenData as $index => $dept)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $dept->nama_departemen }}</td>
                        <td>{{ $dept->jumlah_karyawan }}</td>
                        <td>{{ $dept->jumlah_hadir }}</td>
                        <td>{{ $dept->jumlah_sakit }}</td>
                        <td>{{ $dept->jumlah_izin }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        <footer class="watermark-footer">
            &copy; 2025 by Mimi Sinaga - Programmer
        </footer>

        s
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>