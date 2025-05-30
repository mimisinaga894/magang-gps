<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        <img src="{{ asset('img/loho.png') }}" alt="Logo" class="logo-img" />
        <div>
            <li class="nav-item">
                <a href="{{ route('') }}" class="nav-link">
                    <i class="bi bi-gear-fill"></i> Pengaturan Akun
                </a>
            </li>
            <a href="#" class="nav-link active">Dashboard</a>
            <a href="#" class="nav-link">Profil</a>
            <a href="#" class="nav-link">Pengaturan</a>
            <li class="nav-item mt-3">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link text-white p-0" style="width: 100%; text-align: left;">
                        <i class="bi bi-box-arrow-right"></i> Log Out
                    </button>
        </div>
        <div class="watermark">© 2025 Mimi Sinaga</div>
    </nav>

    <header class="top-navbar">
        <div class="welcome-text">Selamat datang, {{ Auth::user()->name }}!</div>
    </header>

    <main class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header">Dashboard Karyawan</div>
                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                            @endif

                            <form id="masukForm" action="{{ route('absen.masuk') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-semibold">Pilih Status Kehadiran</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="Hadir">Hadir</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Cuti">Cuti</option>
                                        <option value="Sakit">Sakit</option>
                                    </select>
                                </div>
                                <input type="hidden" name="latitude">
                                <input type="hidden" name="longitude">
                                <button type="submit" class="btn btn-success">Absen Sekarang (GPS)</button>
                            </form>

                            <ul class="list-group mt-4">
                                <li class="list-group-item"><strong>Nama:</strong> {{ Auth::user()->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                            </ul>

                            <form id="pulangForm" action="{{ route('absen.pulang') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="latitude">
                                <input type="hidden" name="longitude">
                                <button type="submit" class="btn btn-danger">Absen Pulang</button>
                            </form>

                            <div class="mt-4 text-center">
                                <button class="btn btn-primary" id="view-attendance-btn">Lihat Riwayat Absensi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Riwayat Absensi -->
    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Riwayat Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-3">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jam</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensi as $absen)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $absen->jam }}</td>
                                <td>
                                    @if ($absen->status === 'Hadir')
                                    <span class="badge bg-success">Hadir</span>
                                    @elseif($absen->status === 'Izin')
                                    <span class="badge bg-warning text-dark">Izin</span>
                                    @elseif($absen->status === 'Cuti')
                                    <span class="badge bg-primary">Cuti</span>
                                    @elseif($absen->status === 'Sakit')
                                    <span class="badge bg-danger">Sakit</span>
                                    @else
                                    <span class="badge bg-secondary">{{ $absen->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data absensi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="watermark-footer">© 2025 Mimi Sinaga - Sistem Absensi Karyawan</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const getLocation = () => {
                return new Promise((resolve, reject) => {
                    if (!navigator.geolocation) {
                        reject('Geolocation tidak didukung browser ini');
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        position => resolve(position.coords),
                        error => reject(error.message), {
                            enableHighAccuracy: true,
                            timeout: 5000,
                            maximumAge: 0
                        }
                    );
                });
            };

            const forms = {
                masuk: document.getElementById('masukForm'),
                pulang: document.getElementById('pulangForm')
            };

            Object.entries(forms).forEach(([type, form]) => {
                if (form) {
                    form.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        const button = form.querySelector('button[type="submit"]');
                        button.disabled = true;
                        button.innerHTML =
                            '<span class="spinner-border spinner-border-sm"></span> Loading...';

                        try {
                            const coords = await getLocation();
                            form.querySelector('[name="latitude"]').value = coords.latitude;
                            form.querySelector('[name="longitude"]').value = coords.longitude;
                            form.submit();
                        } catch (error) {
                            alert(`Gagal mengambil lokasi: ${error}`);
                            button.disabled = false;
                            button.innerHTML = type === 'masuk' ? 'Absen Sekarang (GPS)' :
                                'Absen Pulang';
                        }
                    });
                }
            });

            // Modal handler
            document.getElementById('view-attendance-btn')?.addEventListener('click', () => {
                const modal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                modal.show();
            });
        });
    </script>
</body>

</html>