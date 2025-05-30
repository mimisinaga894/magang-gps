<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


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

        .login-container {
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

        h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        p {
            font-size: 1em;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                padding: 20px;
            }

            .form-side,
            .info-side {
                max-width: 80%;
                margin-bottom: 20px;
            }

            .info-img {
                max-width: 85%;
            }
        }

        .info-side h2 h5 {
            font-weight: 300;
            color: rgba(255, 255, 255, 0.85);
            font-size: 1em;
            margin-bottom: 20px;
            letter-spacing: 0.03em;
            line-height: 1;
            font-family: 'Raleway', sans-serif;
            font-style: italic;
            font-weight: 600;
        }

        .info-side p {
            font-weight: 300;
            color: rgba(255, 255, 255, 0.75);
            font-size: 1em;
            margin: 0;
            letter-spacing: 0.02em;
            line-height: 1.5;
        }

        .info-side .fw-bold {
            font-weight: 400;
            color: rgba(255, 255, 255, 0.9);
            font-style: normal;
        }
    </style>

</head>

<body>
    <div class="login-container">

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

            @if (session('error') || $errors->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') ?? $errors->first('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" placeholder="Username" value="{{ old('username') }}">
                    <label for="username">Username</label>
                    @error('username')
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

                <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa Password?</a>

                <button class="btn btn-primary w-100 mb-3">Masuk</button>
            </form>

            <div class="text-center mt-2">
                Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Buat Akun</a>
            </div>
        </div>


        <div class="info-side">
            <div class="d-flex flex-column justify-content-center align-items-center text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Ilustrasi" class="info-img mb-4" />

                <h5 class="fw-semibold mb-3" style="color: #fff;">
                    Absensi jadi mudah, akurat, dan tepat waktu!
                </h5>

                <div class="mt-4" style="color: #e0f7fa;">
                    <p class="mb-1">Powered by</p>
                    <p class="fw-bold mb-0">Mimi Sinaga</p>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
