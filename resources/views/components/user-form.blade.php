<form id="{{ $formId ?? 'registerForm' }}" method="POST" action="{{ route('register') }}"
    class="{{ $isModal ? 'modal-form' : '' }}">
    @csrf
    @if ($isAdmin ?? false)
    <input type="hidden" name="admin" value="true">
    @endif

    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            placeholder="Nama Lengkap" value="{{ old('name') }}">
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
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            placeholder="Email" value="{{ old('email') }}">
        <label for="email">Email</label>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
            <option value="" disabled {{ !old('gender') ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <label for="gender">Jenis Kelamin</label>
        @error('gender')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
            placeholder="Nomor Telepon" value="{{ old('phone') }}">
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

    @if ($isAdmin ?? false)
    <div class="form-floating mb-3">
        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
            <option value="" disabled {{ !old('role') ? 'selected' : '' }}>Pilih Role</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
        </select>
        <label for="role">Role</label>
        @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @else
    <input type="hidden" name="role" value="karyawan">
    @endif

    <div id="karyawanFields" class="{{ $isAdmin && old('role') === 'admin' ? 'd-none' : '' }}">
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik"
                placeholder="NIK" value="{{ old('nik') }}">
            <label for="nik">NIK</label>
            @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <select class="form-select @error('departemen_id') is-invalid @enderror" id="departemen_id"
                name="departemen_id">
                <option value="" disabled {{ !old('departemen_id') ? 'selected' : '' }}>
                    Pilih Departemen
                </option>
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
    </div>

    <div class="form-floating mb-3">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
            name="password" placeholder="Password">
        <label for="password">Password</label>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @unless ($isAdmin ?? false)
    <div class="form-floating mb-3">
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
            id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password">
        <label for="password_confirmation">Konfirmasi Password</label>
        @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @endunless

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
            {{ $submitText ?? 'Daftar' }}
        </button>

        @unless ($isModal ?? false)
        <div class="text-center mt-2">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Masuk</a>
        </div>
        @endunless
    </div>
</form>