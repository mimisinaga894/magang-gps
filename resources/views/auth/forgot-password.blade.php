<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .forgot-container {
            max-width: 450px;
            margin: 80px auto;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .forgot-container h3 {
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

        .form-label {
            font-weight: 600;
        }

        .alert {
            font-size: 14px;
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
    <div class="forgot-container">
        <h3 class="text-center">Lupa Password</h3>

        @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email anda" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login text-decoration-none text-muted">← Kembali ke Login</a>
    </div>
</body>

</html>