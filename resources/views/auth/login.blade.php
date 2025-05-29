<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f0f0;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            min-height: 103vh;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-side,
        .info-side {
            flex: 1;
            padding: 30px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;

        }

        .form-side {
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);

        }

        .info-side {
            background: #0097B2;
            color: white;
            text-align: center;
            padding-top: 20px;
            min-height: 81vh;
            max-width: 900px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0097B2;
        }

        .btn-primary {
            background-color: #0097B2;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #007C8C;
        }

        .logo-img {
            max-height: 80px;
        }

        .info-img {
            max-width: 70%;
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

        .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 100%;
            }

            .info-img {
                max-width: 70%;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- FORM SIDE -->
        <div class="form-side">
            <div class="text-center mb-4">
                <img src="{{ asset('img/loho.png') }}" alt="Logo" class="logo-img" />
                <h4 class="mt-3 fw-bold">SISTEM ABSENSI<br>BERBASIS GEOLOCATION</h4>
            </div>

            <a href="{{ route('google.redirect') }}" class="btn btn-outline-secondary w-100">
                <img src="https://img.icons8.com/color/16/000000/google-logo.png" class="me-2" />
                Masuk dengan Google
            </a>


            <br>

            <div class="text-center mb-3">
                <span>Atau masuk dengan akun</span>
                <hr>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa Password?</a>

                <button class="btn btn-primary w-100 mb-3">Masuk</button>
            </form>

            <div class="text-center mt-2">
                Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Buat Akun</a>
            </div>
        </div>

        <!-- INFO SIDE -->
        <div class="info-side">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('img/logo.png') }}" alt="Ilustrasi" class="info-img mb-4" />
                <h5 class="fw-semibold text-white mb-4">Absensi jadi mudah, akurat, dan tepat waktu!</h5>
                <p class="text-white text-center mb-5">
                    Sistem absensi berbasis geolocation ini memudahkan Anda dalam mencatat waktu kehadiran dengan tingkat akurasi tinggi, kapan saja dan di mana saja.
                </p>
                <div class="mt-4 text-white">
                    <p class="mb-0">Powered by</p>
                    <p class="fw-bold">Mimi Sinaga</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>