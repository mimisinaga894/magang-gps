<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - Sistem Absensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

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


        <div class="content-wrapper">
            <h1 class="mb-4">Dashboard Admin</h1>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="mb-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="bi bi-person-plus"></i> Tambah Pengguna
                </button>
            </div>

            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('admin.editUser', $user->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST"
                                class="d-inline">
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
                    @foreach ($departemenData as $index => $dept)
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

        <div class="modal fade" id="registerModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @include('components.user-form', [
                        'isModal' => true,
                        'isAdmin' => true,
                        'formId' => 'modalRegisterForm',
                        'submitText' => 'Simpan',
                        'departemens' => $departemens,
                        ])
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const roleSelect = document.getElementById('role');
                const karyawanFields = document.getElementById('karyawanFields');

                function toggleKaryawanFields(role) {
                    if (karyawanFields && roleSelect) {
                        if (role === 'admin') {
                            karyawanFields.style.display = 'none';
                            karyawanFields.querySelectorAll('input, select').forEach(input => {
                                input.disabled = true;
                                input.value = '';
                            });
                        } else {
                            karyawanFields.style.display = 'block';
                            karyawanFields.querySelectorAll('input, select').forEach(input => {
                                input.disabled = false;
                            });
                        }
                    }
                }

                roleSelect?.addEventListener('change', function() {
                    toggleKaryawanFields(this.value);
                });


                if (roleSelect) {
                    toggleKaryawanFields(roleSelect.value);
                }


                function showErrors(errors) {

                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());


                    Object.keys(errors).forEach(key => {
                        const input = document.querySelector(`[name="${key}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback';
                            feedback.textContent = errors[key][0];
                            input.parentNode.appendChild(feedback);
                        }
                    });
                }
            });
        </script>
</body>

</html>