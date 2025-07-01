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

        <div class="container">
            <h3 class="mb-4">📋 Halaman Jadwal Kerja</h3>


            <ul class="nav nav-tabs" id="jadwalTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="jadwal-tab" data-bs-toggle="tab" href="#jadwal" role="tab" aria-controls="jadwal" aria-selected="true">
                        🗓️ Jadwal Kerja
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pengumuman-tab" data-bs-toggle="tab" href="#pengumuman" role="tab" aria-controls="pengumuman" aria-selected="false">
                        📢 Pengumuman
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="feedback-tab" data-bs-toggle="tab" href="#feedback" role="tab" aria-controls="feedback" aria-selected="false">
                        📝 Feedback
                    </a>
                </li>
            </ul>

            <div class="tab-content pt-4" id="jadwalTabContent">

                <div class="tab-pane fade show active" id="jadwal" role="tabpanel" aria-labelledby="jadwal-tab">
                    <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">+ Tambah Jadwal</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwal as $index => $j)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $j->karyawan->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($j->shift) }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada jadwal.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade" id="pengumuman" role="tabpanel" aria-labelledby="pengumuman-tab">
                    <h5 class="mb-4 fw-bold text-primary">📢 Pengumuman Terbaru</h5>

                    <div class="list-group">

                        <div class="list-group-item list-group-item-action border-start border-4 border-danger mb-3 p-3 rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-flag-fill text-danger fs-4"></i>
                                    <div>
                                        <div class="fw-semibold fs-6">Libur Nasional</div>
                                        <div class="text-muted small">17 Agustus – Dirgahayu Republik Indonesia 🇮🇩</div>
                                    </div>
                                </div>
                                <button onclick="alert('Notifikasi berhasil dikirim ke semua karyawan!')" class="btn btn-sm btn-outline-primary">
                                    📤 Kirim
                                </button>
                            </div>
                        </div>
                        <div class="list-group-item list-group-item-action border-start border-4 border-warning mb-3 p-3 rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-clock-fill text-warning fs-4"></i>
                                    <div>
                                        <div class="fw-semibold fs-6">Update Shift</div>
                                        <div class="text-muted small">Shift malam dipindahkan ke shift pagi mulai minggu depan.</div>
                                    </div>
                                </div>
                                <button onclick="alert('Notifikasi berhasil dikirim ke semua karyawan!')" class="btn btn-sm btn-outline-primary">
                                    📤 Kirim
                                </button>
                            </div>
                        </div>
                        <div class="list-group-item list-group-item-action border-start border-4 border-info mb-3 p-3 rounded shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-calendar-event-fill text-info fs-4"></i>
                                    <div>
                                        <div class="fw-semibold fs-6">Rapat Evaluasi</div>
                                        <div class="text-muted small">Jumat, 10.00 WIB via Zoom.</div>
                                    </div>
                                </div>
                                <button onclick="alert('Notifikasi berhasil dikirim ke semua karyawan!')" class="btn btn-sm btn-outline-primary">
                                    📤 Kirim
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                    <h5 class="mb-3">📂 Riwayat Feedback</h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Karyawan</th>
                                <th>Kategori</th>
                                <th>Isi</th>
                                <th>Balasan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>Andi Saputra</td>
                                <td>Saran</td>
                                <td>Tolong tambahkan shift malam di hari Sabtu.</td>
                                <td>-</td>
                                <td><span class="badge bg-warning text-dark">Diproses</span></td>
                                <td>
                                    <form onsubmit="return balasFeedback(this, 1)">
                                        <textarea class="form-control mb-2" placeholder="Tulis balasan..."></textarea>
                                        <button class="btn btn-sm btn-primary">Balas</button>
                                    </form>
                                </td>
                            </tr>


                            <tr>
                                <td>2</td>
                                <td>Rina Sari</td>
                                <td>Pertanyaan</td>
                                <td>Apakah libur bisa diganti dengan cuti tahunan?</td>
                                <td>Ya, bisa diajukan ke HRD maksimal H-3.</td>
                                <td><span class="badge bg-success">Direspon</span></td>
                                <td><small><i>Sudah dibalas</i></small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <script>
                    function balasFeedback(form, id) {
                        const textarea = form.querySelector("textarea");
                        if (!textarea.value.trim()) {
                            alert("Isi balasan tidak boleh kosong.");
                            return false;
                        }

                        alert("Balasan untuk feedback #" + id + " berhasil dikirim!");

                        return false;
                    }
                </script>
            </div>
        </div>
    </div>

    <div class="watermark text-center mt-5 mb-4 text-muted" style="font-size: 0.75rem; font-style: italic;">
        &copy; by Mimi Sinaga ❤️
    </div>

</body>

</html>