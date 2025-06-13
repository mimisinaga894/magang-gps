<!DOCTYPE html>
<html lang="id">

<head>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        :root {
            --primary: #4A90E2;
            --secondary: #2C3E50;
            --light: #F4F6F8;
            --dark: #1F2D3D;
            --accent: #FF6B6B;
            --rounded: 12px;
            --shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            --font: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--light);
            min-height: 100vh;
            padding-top: 70px;
            padding-bottom: 70px;
            margin: 0;
            color: var(--dark);
        }

        .sidebar {
            background-color: var(--secondary);
            color: white;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 0;
        }

        .sidebar .logo {
            font-size: 1.6rem;
            font-weight: bold;
            text-align: center;
            color: white;
            margin-bottom: 1.5rem;
        }

        .sidebar .nav-link {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: block;
            transition: background 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .watermark {
            font-size: 0.75rem;
            text-align: center;
            opacity: 0.4;
            font-style: italic;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .top-navbar {
            position: fixed;
            top: 0;
            left: 250px;
            height: 60px;
            width: calc(100% - 250px);
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 20px;
            box-shadow: var(--shadow);
            z-index: 1000;
        }

        .top-navbar .welcome-text {
            font-weight: 600;
        }

        .btn {
            padding: 10px 20px;
            border-radius: var(--rounded);
            font-weight: 600;
            transition: 0.3s ease;
            cursor: pointer;
            text-align: center;
            border: none;
        }

        .btn-success {
            background-color: #2ecc71;
            color: white;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-primary {
            background-color: var(--secondary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1a252f;
        }

        .btn-warning {
            background-color: #f1c40f;
            color: black;
        }

        .btn-warning:hover {
            background-color: #d4ac0d;
        }

        .btn-danger {
            background-color: var(--accent);
            color: white;
        }

        .btn-danger:hover {
            background-color: #e74c3c;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .work-hours-container {
            position: fixed;
            top: 10px;
            right: 20px;
            background-color: var(--secondary);
            color: white;
            padding: 10px 16px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow);
            z-index: 1100;
            font-size: 0.9rem;
        }

        .work-hours-box {
            background-color: var(--dark);
            padding: 8px 14px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }

        .work-hours-box:hover {
            background-color: var(--light);
            color: var(--dark);
        }

        .work-hours-box i {
            color: var(--accent);
            font-size: 1.1rem;
        }

        .btn-group-absensi {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .list-group-item strong {
            display: inline-block;
            width: 120px;
        }

        footer.watermark-footer {
            position: fixed;
            bottom: 0;
            left: 250px;
            width: calc(100% - 250px);
            padding: 1rem 0;
            background: var(--light);
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <nav class="sidebar">
        <img src="{{ asset('img/loho.png') }}" alt="Logo Sistem Absensi"
            style="max-width: 150px; height: auto;">
        <div>
            <a href="#" class="nav-link active">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="nav-link"><i class="bi bi-gear-fill"></i> Profile</a>
            <a href="{{ route('profile.edit') }}" class="nav-link"><i class="bi bi-gear-fill"></i> Pengaturan Akun</a>
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

    <div class="work-hours-container" title="Jam Kerja">
        <div class="work-hours-box" title="Jam Masuk Kerja">
            <i class="bi bi-clock-history"></i> 08:00
        </div>
        <div class="work-hours-box" title="Jam Pulang Kerja">
            <i class="bi bi-clock-history"></i> 16:30
        </div>
    </div>
    <div id="notification" style="display:none; padding:10px; background-color:#d4edda; color:#155724; border:1px solid #c3e6cb; border-radius:5px; margin-bottom:20px; text-align:center;">
        Absensi Pulang berhasil dicatat!
    </div>

    <main class="main-content">
        <div class="card shadow-sm">
            <div class="card-header">Dashboard Karyawan</div>
            <div class="card-body">

                <ul class="list-group mt-4">
                    <li class="list-group-item"><strong>Nama:</strong> {{ Auth::user()->name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                </ul>
                <br>

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
                        </select>
                    </div>
                    <input type="hidden" name="latitude" />
                    <input type="hidden" name="longitude" />
                    <button type="submit" class="btn btn-success w-100">Absen Sekarang (GPS)</button>
                </form>

                <form id="pulangForm" action="{{ route('absen.pulang') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="latitude" />
                    <input type="hidden" name="longitude" />
                    <button type="submit" class="btn btn-danger w-100">Absen Pulang</button>
                </form>


                <div class="btn-group-absensi">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">Ajukan Cuti</button>
                    <button class="btn btn-secondary" id="view-attendance-btn">Lihat Riwayat Absensi</button>
                </div>

            </div>
        </div>
    </main>


    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
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

    <div class="modal fade" id="cutiModal" tabindex="-1" aria-labelledby="cutiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cuti.submit') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cutiModalLabel">Pengajuan Cuti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cuti_tanggal" class="form-label">Tanggal Cuti</label>
                        <input type="date" class="form-control" name="tanggal" id="cuti_tanggal" required />
                    </div>
                    <div class="mb-3">
                        <label for="cuti_alasan" class="form-label">Alasan Cuti</label>
                        <textarea name="alasan" id="cuti_alasan" rows="3" class="form-control" placeholder="Isi alasan cuti..." required></textarea>
                    </div>
                    <input type="hidden" name="status" value="Cuti" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ajukan Cuti</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="watermark-footer">© 2025 Mimi Sinaga</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('view-attendance-btn').addEventListener('click', function() {
            const attendanceModal = new bootstrap.Modal(document.getElementById('attendanceModal'));
            attendanceModal.show();
        });

        function getLocationAndSetInputs(form) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    form.querySelector('input[name=latitude]').value = position.coords.latitude;
                    form.querySelector('input[name=longitude]').value = position.coords.longitude;
                    form.submit();
                }, function() {
                    alert("Gagal mendapatkan lokasi, silakan coba lagi.");
                });
            } else {
                alert("Geolocation tidak didukung oleh browser Anda.");
            }
        }


        document.getElementById('masukForm').addEventListener('submit', function(e) {
            e.preventDefault();
            getLocationAndSetInputs(this);
        });

        document.getElementById('pulangForm').addEventListener('submit', function(e) {
            e.preventDefault();
            getLocationAndSetInputs(this);
        });
    </script>
</body>

</html>