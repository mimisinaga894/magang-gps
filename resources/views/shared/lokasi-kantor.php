<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lokasi Kantor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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
            z-index: 1000;
        }

        .sidebar .logo {
            font-size: 1.6rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
        }

        .sidebar .logo img {
            max-width: 150px;
            height: auto;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            transition: all 0.3s;
            border-radius: 6px;
            margin: 2px 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #3d4f74;
            color: white;
            text-decoration: none;
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
            min-height: 100vh;
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
            z-index: 999;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-navbar .welcome-text {
            margin-right: auto;
            font-weight: 600;
            color: white;
        }

        .content-wrapper {
            margin-top: 80px;
        }

        .info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .info-card h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .info-card p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .location-info {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            border-left: 4px solid #6db3fd;
        }

        .location-info h5 {
            color: #2d3b55;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .location-info hr {
            border-color: #e9ecef;
            margin: 15px 0;
        }

        .location-info .mb-3 {
            margin-bottom: 1rem;
        }

        .location-info strong {
            color: #495057;
            font-weight: 600;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .card {
            background: #ffffff;
            transition: all 0.3s ease-in-out;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            border-bottom: none;
            padding: 20px;
        }

        .card-header h5 {
            font-weight: 600;
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 0 0 12px 12px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .alert-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            color: #1565c0;
        }

        .badge {
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 20px;
        }

        .bg-success {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2d3b55 0%, #1f2a3e 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 59, 85, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
                transition: width 0.3s;
            }

            .sidebar.show {
                width: 250px;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .top-navbar {
                left: 0;
                width: 100%;
            }

            .location-info {
                margin-bottom: 15px;
            }

            #map {
                height: 300px;
            }
        }

        .loading {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="info-card loading">
                            <h2 class="mb-0">
                                <i class="bi bi-geo-alt-fill"></i> Lokasi Kantor
                            </h2>
                            <p class="mb-0">Informasi lokasi kantor untuk keperluan absensi</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="location-info loading">
                            <h5><i class="bi bi-geo-alt text-primary"></i> Informasi Lokasi</h5>
                            <hr>
                            <div class="mb-3">
                                <strong>Nama Kantor:</strong><br>
                                <span class="text-muted">PT.Energi Positif</span>
                            </div>
                            <div class="mb-3">
                                <strong>Alamat:</strong><br>
                                <span class="text-muted">Jl. Setia Budiya No. 123, Jakarta</span>
                            </div>
                            <div class="mb-3">
                                <strong>Koordinat:</strong><br>
                                <span class="text-muted">
                                    <i class="bi bi-geo"></i> -6.2088, 106.8456
                                </span>
                            </div>
                            <div class="mb-3">
                                <strong>Radius Absensi:</strong><br>
                                <span class="badge bg-success">100 meter</span>
                            </div>
                        </div>

                        <div class="location-info loading">
                            <h5><i class="bi bi-clock text-info"></i> Jam Operasional</h5>
                            <hr>
                            <div class="mb-2">
                                <strong>Senin - Jumat:</strong><br>
                                <span class="text-muted">08:00 - 17:00</span>
                            </div>
                            <div class="mb-2">
                                <strong>Sabtu:</strong><br>
                                <span class="text-muted">08:00 - 12:00</span>
                            </div>
                            <div class="mb-2">
                                <strong>Minggu:</strong><br>
                                <span style="color: #e74c3c;">Libur</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card loading">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-map"></i> Peta Lokasi Kantor
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-info loading">
                            <i class="bi bi-info-circle"></i>
                            <strong>Informasi Penting:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Pastikan GPS pada perangkat Anda aktif saat melakukan absensi</li>
                                <li>Absensi hanya dapat dilakukan dalam radius 100 meter dari kantor</li>
                                <li>Jika mengalami kendala, hubungi bagian HRD</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var map = L.map('map').setView([-6.2088, 106.8456], 16);


            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);


            var officeIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var officeMarker = L.marker([-6.2088, 106.8456], {
                icon: officeIcon
            }).addTo(map);
            officeMarker.bindPopup(`
                <div style="text-align: center;">
                    <h6><strong>🏢 Kantor Pusat</strong></h6>
                    <p>PT. Nama Perusahaan</p>
                    <small>Jl. Contoh Alamat No. 123, Jakarta</small>
                </div>
            `).openPopup();

            var circle = L.circle([-6.2088, 106.8456], {
                color: '#28a745',
                fillColor: '#90EE90',
                fillOpacity: 0.3,
                radius: 100,
                weight: 2
            }).addTo(map);

            circle.bindPopup(`
                <div style="text-align: center;">
                    <h6><strong>📍 Radius Absensi</strong></h6>
                    <p>100 meter dari kantor</p>
                    <small>Anda harus berada dalam area ini untuk absensi</small>
                </div>
            `);

            L.control.scale({
                metric: true,
                imperial: false
            }).addTo(map);
            map.zoomControl.setPosition('topright');
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
            setTimeout(function() {
                document.querySelectorAll('.loading').forEach(function(element) {
                    element.style.animation = 'fadeIn 0.5s forwards';
                });
            }, 100);
        });

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>