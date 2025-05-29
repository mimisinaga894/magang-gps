<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', sans-serif;
        }

        .reset-container {
            max-width: 480px;
            margin: 80px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .reset-container h3 {
            margin-bottom: 25px;
            color: #0097B2;
        }

        .btn-primary {
            background-color: #0097B2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #007a8a;
        }

        .form-control {
            border-radius: 6px;
        }

        .form-label {
            font-weight: 600;
        }

        .back-to-login {
            margin-top: 20px;
            display: block;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <h3 class="text-center">Reset Password</h3>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Password baru" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login text-decoration-none text-muted">← Kembali ke Login</a>
    </div>
</body>

</html>