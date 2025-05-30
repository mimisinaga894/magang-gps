<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url("{{ asset('img/logoo.jpg') }}");
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            z-index: 0;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: stretch;
            max-width: 960px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            padding: 20px;
        }

        .form-side,
        .info-side {
            flex: 1;
            padding: 30px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-sizing: border-box;
        }

        .form-side {
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .info-side {
            background: linear-gradient(135deg, #0097B2, #007C8C);
            color: white;
            text-align: center;
        }

        .form-title {
            font-size: 1.8em;
            font-weight: 600;
            color: #0097B2;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 1em;
            width: 100%;
        }

        .form-control:focus {
            border-color: #0097B2;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 151, 178, 0.4);
        }

        .btn-primary {
            background-color: #0097B2;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #007C8C;
        }

        .info-img {
            max-width: 75%;
            margin: 0 auto 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .logo-img {
            max-height: 70px;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-outline-secondary {
            border-radius: 5px;
            border-color: #0097B2;
        }

        .btn-outline-secondary:hover {
            background-color: #0097B2;
            color: white;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                max-width: 90%;
                padding: 10px;
            }

            .info-side {
                min-height: auto;
            }

            .info-img {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="form-side">
            <div class="text-center mb-4">
                <img src="{{ asset('img/loho.png') }}" alt="Logo" class="logo-img" />
                <h4 class="mt-3 fw-bold">SISTEM ABSENSI<br>BERBASIS GEOLOCATION</h4>
            </div>

            <a href="{{ route('google.redirect') }}" class="btn btn-outline-secondary w-100">
                <img src="https://img.icons8.com/color/16/000000/google-logo.png" class="me-2" />
                Daftar dengan Google
            </a>
            <br>

            <div class="text-center mb-3">
                <span>Atau daftar dengan akun</span>
                <hr>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>


                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                </div>


                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>


                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Daftar</button>

                <div class="text-center mt-2">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Masuk</a>
                </div>
            </form>
        </div>

        <!-- INFO SIDE -->
        <div class="info-side">
            <img src="{{ asset('img/logo.png') }}" alt="Ilustrasi" class="info-img mb-4" />
            <h5 class="fw-semibold">Daftarkan akun Anda</h5>
            <br>
            <h5 class="fw-semibold">dan mulai gunakan absensi berbasis lokasi!</h5>
            <br><br>
            <div class="mt-4 text-white">
                <p class="mb-0">Powered by</p>
                <p class="fw-bold">Mimi Sinaga</p>
            </div>
        </div>
    </div>

</body>

</html>