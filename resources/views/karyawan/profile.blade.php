<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pengaturan Akun - Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h3>🔧 Pengaturan Akun</h3>
        <p class="text-muted">Perbarui informasi akun Anda dengan aman di sini.</p>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('karyawan.profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', Auth::user()->name) }}" required />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru <small class="text-muted">(Biarkan kosong jika tidak diubah)</small></label>
                <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>