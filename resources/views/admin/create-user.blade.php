<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Tambah Pengguna Baru</h1>

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.storeUser') }}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" placeholder="Nama Lengkap" value="{{ old('name') }}">
                <label>Nama Lengkap</label>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('username') is-invalid @enderror"
                    name="username" placeholder="Username" value="{{ old('username') }}">
                <label>Username</label>
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" placeholder="Email" value="{{ old('email') }}">
                <label>Email</label>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Password">
                <label>Password</label>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control"
                    name="password_confirmation" placeholder="Konfirmasi Password">
                <label>Konfirmasi Password</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select @error('role') is-invalid @enderror" name="role" id="role">
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
                <label>Role</label>
                @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="karyawanFields" class="d-none">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                        name="nik" placeholder="NIK" value="{{ old('nik') }}">
                    <label>NIK</label>
                    @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select @error('departemen_id') is-invalid @enderror"
                        name="departemen_id">
                        <option value="">Pilih Departemen</option>
                        @foreach ($departemens as $departemen)
                        <option value="{{ $departemen->id }}"
                            {{ old('departemen_id') == $departemen->id ? 'selected' : '' }}>
                            {{ $departemen->nama }}
                        </option>
                        @endforeach
                    </select>
                    <label>Departemen</label>
                    @error('departemen_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                        name="jabatan" placeholder="Jabatan" value="{{ old('jabatan') }}">
                    <label>Jabatan</label>
                    @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const karyawanFields = document.getElementById('karyawanFields');

        function toggleFields() {
            if (roleSelect.value === 'karyawan') {
                karyawanFields.classList.remove('d-none');
            } else {
                karyawanFields.classList.add('d-none');
            }
        }

        roleSelect.addEventListener('change', toggleFields);
        window.addEventListener('DOMContentLoaded', toggleFields);
    </script>
</body>

</html>