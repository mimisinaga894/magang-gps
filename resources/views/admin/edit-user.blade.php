<!DOCTYPE html>
<html lang="id">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Pengguna</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}">
                <label for="name">Nama Lengkap</label>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                    name="username" placeholder="Username" value="{{ old('username', $user->username) }}">
                <label for="username">Username</label>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="Email" value="{{ old('email', $user->email) }}">
                <label for="email">Email</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                    <option value="" disabled>Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                <label for="gender">Jenis Kelamin</label>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    name="phone" placeholder="Nomor Telepon" value="{{ old('phone', $user->phone) }}">
                <label for="phone">Nomor Telepon</label>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Alamat"
                    style="height: 100px">{{ old('address', $user->address) }}</textarea>
                <label for="address">Alamat</label>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                    <option value="" disabled>Pilih Role</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ old('role', $user->role) == 'karyawan' ? 'selected' : '' }}>Karyawan
                    </option>
                </select>
                <label for="role">Role</label>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Karyawan fields -->
            <div id="karyawanFields" class="{{ $user->role === 'admin' ? 'd-none' : '' }}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                        name="nik" placeholder="NIK" value="{{ old('nik', $user->karyawan->nik ?? '') }}" required>
                    <label for="nik">NIK</label>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select @error('departemen_id') is-invalid @enderror" id="departemen_id"
                        name="departemen_id" required>
                        <option value="" disabled>Pilih Departemen</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id }}"
                                {{ old('departemen_id', $user->karyawan->departemen_id ?? '') == $departemen->id ? 'selected' : '' }}>
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
                        name="jabatan" placeholder="Jabatan"
                        value="{{ old('jabatan', $user->karyawan->jabatan ?? '') }}" required>
                    <label for="jabatan">Jabatan</label>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const karyawanFields = document.getElementById('karyawanFields');

            function toggleKaryawanFields(role) {
                if (karyawanFields) {
                    const isKaryawan = role === 'karyawan';
                    karyawanFields.classList.toggle('d-none', !isKaryawan);

                    const fields = karyawanFields.querySelectorAll('input, select');

                    fields.forEach(field => {
                        field.disabled = !isKaryawan;
                        field.required = isKaryawan;
                    });
                }
            }

            if (roleSelect) {
                // Initial toggle based on current role
                toggleKaryawanFields(roleSelect.value);

                // Add change event listener
                roleSelect.addEventListener('change', function() {
                    toggleKaryawanFields(this.value);
                });
            }
        });
    </script>
</body>

</html>
