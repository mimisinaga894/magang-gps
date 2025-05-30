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

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="Nama Lengkap" value="{{ old('name') }}">
                    <label for="name">Nama Lengkap</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" placeholder="Username" value="{{ old('username') }}">
                    <label for="username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Email" value="{{ old('email') }}">
                    <label for="email">Email</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <label for="gender">Jenis Kelamin</label>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" placeholder="Nomor Telepon" value="{{ old('phone') }}">
                    <label for="phone">Nomor Telepon</label>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Alamat"
                        style="height: 100px">{{ old('address') }}</textarea>
                    <label for="address">Alamat</label>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select @error('departemen_id') is-invalid @enderror" id="departemen_id"
                        name="departemen_id">
                        <option value="" disabled selected>Pilih Departemen</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id }}"
                                {{ old('departemen_id') == $departemen->id ? 'selected' : '' }}>
                                {{ $departemen->nama }}
                            </option>
                        @endforeach
                    </select>
                    <label for="departemen_id">Departemen</label>
                    @error('departemen_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                        name="jabatan" placeholder="Jabatan" value="{{ old('jabatan') }}">
                    <label for="jabatan">Jabatan</label>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Password">
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password_confirmation"
                        name="password_confirmation" placeholder="Konfirmasi Password">
                    <label for="password_confirmation">Konfirmasi Password</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar</button>

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
