<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            background: linear-gradient(135deg, rgb(255, 255, 255) 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px 20px;
            max-width: 1200px;
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

        .dashboard-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin: 0;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: #f8f9fa;
            border-radius: 20px 20px 0 0;
            padding: 20px;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .user-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .user-info .list-group-item {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            backdrop-filter: blur(10px);
        }

        .location-status {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .location-status.out-of-range {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .location-status.checking {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
        }

        .btn-attendance {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-group-absensi {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn-group-absensi .btn {
            flex: 1;
            min-width: 200px;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 500;
        }

        .form-select,
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.1);
            color: white;
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 0.8rem;
        }

        .mini-map {
            height: 200px;
            border-radius: 15px;
            margin-top: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 60px;
                padding: 20px;
            }

            .sidebar {
                width: 60px;
                padding: 10px;
            }

            .dashboard-header h1 {
                font-size: 1.8rem;
            }

            .btn-group-absensi .btn {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo text-center">
            <img src="{{ asset('img/loho.png') }}" alt="Logo Sistem Absensi" style="max-width: 150px;">
        </div>
        <a href="{{ route('karyawan.dashboard') }}" class="nav-link active">Dashboard</a>
        <a href="{{ route('karyawan.lokasi-kantor') }}" class="nav-link active">
            <i class="bi bi-geo-alt-fill"></i> Lokasi Kantor
        </a>
        <a href="{{ route('karyawan.profile') }}" class="nav-link">
            <i class="bi bi-gear-fill"></i> Pengaturan Akun
        </a>


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

    <main class="main-content">
        <div class="dashboard-header">
            <h1><i class="bi bi-person-circle"></i> Dashboard Karyawan</h1>
            <p>Sistem Absensi Berbasis GPS - Pantau kehadiran Anda dengan mudah</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <i class="bi bi-speedometer2"></i> Informasi Pribadi & Absensi
            </div>
            <div class="card-body">
                <div class="user-info">
                    <h5><i class="bi bi-person-badge"></i> Informasi Pengguna</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong><i class="bi bi-person"></i> Nama:</strong> John Doe</li>
                        <li class="list-group-item"><strong><i class="bi bi-envelope"></i> Email:</strong> john.doe@company.com</li>
                        <li class="list-group-item"><strong><i class="bi bi-building"></i> Departemen:</strong> IT Development</li>
                    </ul>
                </div>

                <div class="location-status checking" id="locationStatus">
                    <div class="loading-spinner spinner-border" role="status" id="loadingSpinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div id="locationInfo">
                        <i class="bi bi-geo-alt"></i>
                        <strong>Memeriksa Lokasi...</strong>
                        <div class="distance-info">Mohon tunggu, sedang mengecek posisi Anda</div>
                    </div>
                </div>


                <div class="mini-map" id="miniMap"></div>

                <div id="alertContainer"></div>

                <form id="masukForm" method="POST" style="display: none;">
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">
                            <i class="bi bi-clipboard-check"></i> Pilih Status Kehadiran
                        </label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                        </select>
                    </div>
                    <input type="hidden" name="latitude" />
                    <input type="hidden" name="longitude" />
                    <button type="submit" class="btn btn-success btn-attendance w-100">
                        <i class="bi bi-check-circle"></i> Absen Masuk
                    </button>
                </form>

                <form id="pulangForm" method="POST" class="mt-3" style="display: none;">
                    <input type="hidden" name="latitude" />
                    <input type="hidden" name="longitude" />
                    <button type="submit" class="btn btn-danger btn-attendance w-100">
                        <i class="bi bi-box-arrow-right"></i> Absen Pulang
                    </button>
                </form>

                <div class="btn-group-absensi">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">
                        <i class="bi bi-calendar-plus"></i> Ajukan Cuti
                    </button>
                    <button class="btn btn-secondary" id="view-attendance-btn">
                        <i class="bi bi-clock-history"></i> Lihat Riwayat Absensi
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pengumumanModal">
                        <i class="bi bi-megaphone"></i> Pengumuman
                    </button>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                        <i class="bi bi-chat-dots"></i> Feedback
                    </button>
                </div>
            </div>
        </div>
    </main>


    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">
                        <i class="bi bi-clock-history"></i> Riwayat Absensi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-3">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col"><i class="bi bi-calendar"></i> Tanggal</th>
                                <th scope="col"><i class="bi bi-clock"></i> Jam</th>
                                <th scope="col"><i class="bi bi-info-circle"></i> Status</th>
                                <th scope="col"><i class="bi bi-geo-alt"></i> Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>04 Juli 2025</td>
                                <td>08:15</td>
                                <td><span class="badge bg-success">Hadir</span></td>
                                <td>Dalam radius kantor</td>
                            </tr>
                            <tr>
                                <td>03 Juli 2025</td>
                                <td>08:30</td>
                                <td><span class="badge bg-warning text-dark">Izin</span></td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>02 Juli 2025</td>
                                <td>08:00</td>
                                <td><span class="badge bg-success">Hadir</span></td>
                                <td>Dalam radius kantor</td>
                            </tr>
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
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cutiModalLabel">
                        <i class="bi bi-calendar-plus"></i> Pengajuan Cuti
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cuti_tanggal" class="form-label">
                            <i class="bi bi-calendar"></i> Tanggal Cuti
                        </label>
                        <input type="date" class="form-control" name="tanggal" id="cuti_tanggal" required />
                    </div>
                    <div class="mb-3">
                        <label for="cuti_alasan" class="form-label">
                            <i class="bi bi-chat-text"></i> Alasan Cuti
                        </label>
                        <textarea name="alasan" id="cuti_alasan" rows="3" class="form-control"
                            placeholder="Jelaskan alasan pengajuan cuti Anda..." required></textarea>
                    </div>
                    <input type="hidden" name="status" value="Cuti" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Ajukan Cuti
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="pengumumanModal" tabindex="-1" aria-labelledby="pengumumanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengumumanModalLabel">
                        <i class="bi bi-megaphone"></i> Pengumuman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <h5>Libur Nasional</h5>
                    <p>17 Agustus – Dirgahayu Republik Indonesia 🇮🇩</p>
                    <h5>Update Shift</h5>
                    <p>Shift malam dipindahkan ke shift pagi mulai minggu depan.</p>
                    <h5>Rapat Evaluasi</h5>
                    <p>Jumat, 10.00 WIB via Zoom.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">
                        <i class="bi bi-chat-dots"></i> Feedback
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <h5>Apakah libur dapat diganti dengan cuti tahunan?</h5>
                    <p>Ya, bisa diajukan ke HRD maksimal H-3.</p>
                    <h5>Bagaimana prosedur pengajuan cuti?</h5>
                    <p>Prosedur pengajuan cuti dapat dilihat di portal HRD.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <footer class="watermark-footer">© 2025 Mimi Sinaga</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const OFFICE_LOCATION = {
            lat: -6.2088,
            lng: 106.8456,
            name: "Kantor Pusat",
            address: "Jl. Contoh Alamat No. 123, Jakarta",
            maxDistance: 100
        };

        let map;
        let userMarker;
        let officeMarker;
        let radiusCircle;
        let currentUserLocation = null;


        function initMap() {
            map = L.map('miniMap').setView([OFFICE_LOCATION.lat, OFFICE_LOCATION.lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);


            const officeIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            officeMarker = L.marker([OFFICE_LOCATION.lat, OFFICE_LOCATION.lng], {
                icon: officeIcon
            }).addTo(map);
            officeMarker.bindPopup(`
                <div style="text-align: center;">
                    <h6><strong>🏢 ${OFFICE_LOCATION.name}</strong></h6>
                    <p>${OFFICE_LOCATION.address}</p>
                </div>
            `);

            radiusCircle = L.circle([OFFICE_LOCATION.lat, OFFICE_LOCATION.lng], {
                color: '#28a745',
                fillColor: '#90EE90',
                fillOpacity: 0.3,
                radius: OFFICE_LOCATION.maxDistance
            }).addTo(map);

            radiusCircle.bindPopup('Radius Absensi: ' + OFFICE_LOCATION.maxDistance + ' meter');
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Radius bumi dalam meter
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c;
        }


        function updateLocationStatus(lat, lng) {
            const distance = calculateDistance(lat, lng, OFFICE_LOCATION.lat, OFFICE_LOCATION.lng);
            const isInRange = distance <= OFFICE_LOCATION.maxDistance;

            const statusEl = document.getElementById('locationStatus');
            const infoEl = document.getElementById('locationInfo');
            const masukForm = document.getElementById('masukForm');
            const pulangForm = document.getElementById('pulangForm');

            if (isInRange) {
                statusEl.className = 'location-status';
                infoEl.innerHTML = `
                    <i class="bi bi-geo-alt-fill"></i>
                    <strong>Lokasi Valid - Siap Absensi</strong>
                    <div class="distance-info">Jarak: ${Math.round(distance)} meter dari kantor</div>
                `;
                masukForm.style.display = 'block';
                pulangForm.style.display = 'block';
            } else {
                statusEl.className = 'location-status out-of-range';
                infoEl.innerHTML = `
                    <i class="bi bi-geo-alt"></i>
                    <strong>Lokasi Terlalu Jauh</strong>
                    <div class="distance-info">Jarak: ${Math.round(distance)} meter (maks: ${OFFICE_LOCATION.maxDistance}m)</div>
                `;
                masukForm.style.display = 'none';
                pulangForm.style.display = 'none';
            }


            if (userMarker) {
                map.removeLayer(userMarker);
            }

            const userIcon = L.icon({
                iconUrl: isInRange ?
                    'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png' : 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            userMarker = L.marker([lat, lng], {
                icon: userIcon
            }).addTo(map);
            userMarker.bindPopup(`
                <div style="text-align: center;">
                    <h6><strong>📍 Lokasi Anda</strong></h6>
                    <p>Jarak: ${Math.round(distance)} meter</p>
                    <p>Status: ${isInRange ? '✅ Dalam Radius' : '❌ Diluar Radius'}</p>
                </div>
            `);


            const group = new L.featureGroup([officeMarker, userMarker]);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        function getUserLocation() {
            const statusEl = document.getElementById('locationStatus');
            const loadingSpinner = document.getElementById('loadingSpinner');

            loadingSpinner.style.display = 'block';
            statusEl.className = 'location-status checking';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        loadingSpinner.style.display = 'none';
                        currentUserLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        updateLocationStatus(position.coords.latitude, position.coords.longitude);
                    },
                    function(error) {
                        loadingSpinner.style.display = 'none';
                        statusEl.className = 'location-status out-of-range';
                        document.getElementById('locationInfo').innerHTML = `
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Gagal Mendapatkan Lokasi</strong>
                            <div class="distance-info">Silakan aktifkan GPS dan refresh halaman</div>
                        `;
                        showAlert('Gagal mendapatkan lokasi. Pastikan GPS aktif dan izinkan akses lokasi.', 'danger');
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000
                    }
                );
            } else {
                loadingSpinner.style.display = 'none';
                statusEl.className = 'location-status out-of-range';
                document.getElementById('locationInfo').innerHTML = `
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>GPS Tidak Didukung</strong>
                    <div class="distance-info">Browser Anda tidak mendukung geolocation</div>
                `;
                showAlert('Browser Anda tidak mendukung GPS.', 'danger');
            }
        }


        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            alertContainer.appendChild(alert);


            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }


        function setLocationInputs(form) {
            if (currentUserLocation) {
                form.querySelector('input[name=latitude]').value = currentUserLocation.lat;
                form.querySelector('input[name=longitude]').value = currentUserLocation.lng;
                return true;
            }
            return false;
        }


        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            getUserLocation();


            setInterval(getUserLocation, 30000);

            document.getElementById('masukForm').addEventListener('submit', function(e) {
                e.preventDefault();

                if (!setLocationInputs(this)) {
                    showAlert('Lokasi belum terdeteksi. Silakan tunggu beberapa saat.', 'warning');
                    return;
                }


                showAlert('Absen masuk berhasil dicatat!', 'success');


                setTimeout(() => {
                    this.style.display = 'none';
                    document.getElementById('pulangForm').style.display = 'block';
                }, 1000);
            });


            document.getElementById('pulangForm').addEventListener('submit', function(e) {
                e.preventDefault();

                if (!setLocationInputs(this)) {
                    showAlert('Lokasi belum terdeteksi. Silakan tunggu beberapa saat.', 'warning');
                    return;
                }


                showAlert('Absen pulang berhasil dicatat!', 'success');


                setTimeout(() => {
                    this.style.display = 'none';
                    document.getElementById('masukForm').style.display = 'block';
                }, 1000);
            });

            document.getElementById('view-attendance-btn').addEventListener('click', function() {
                const attendanceModal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                attendanceModal.show();
            });


            document.querySelector('#cutiModal form').addEventListener('submit', function(e) {
                e.preventDefault();
                showAlert('Pengajuan cuti berhasil dikirim!', 'success');
                const modal = bootstrap.Modal.getInstance(document.getElementById('cutiModal'));
                modal.hide();
            });
        });
    </script>
</body>

</html>