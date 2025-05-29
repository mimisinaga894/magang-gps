<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lokasi Kantor
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        {{-- Tombol Tambah --}}
        <label for="add_button" class="btn btn-primary mb-4 cursor-pointer">Tambah Lokasi Kantor</label>

        {{-- Modal Tambah --}}
        <input type="checkbox" id="add_button" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box relative">
                <label for="add_button" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="text-lg font-bold mb-4">Tambah Lokasi Kantor</h3>

                <form action="{{ route('lokasi-kantor.store') }}" method="POST">
                    @csrf
                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Kota <span class="text-red-500">*</span></span>
                        <input type="text" name="kota" value="{{ old('kota') }}" placeholder="Kota" class="input input-bordered w-full" required />
                        @error('kota')<span class="text-error text-sm">{{ $message }}</span>@enderror
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Alamat <span class="text-red-500">*</span></span>
                        <textarea name="alamat" class="textarea textarea-bordered w-full" required>{{ old('alamat') }}</textarea>
                        @error('alamat')<span class="text-error text-sm">{{ $message }}</span>@enderror
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Latitude <span class="text-red-500">*</span></span>
                        <input type="text" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude" class="input input-bordered w-full" required />
                        @error('latitude')<span class="text-error text-sm">{{ $message }}</span>@enderror
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Longitude <span class="text-red-500">*</span></span>
                        <input type="text" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude" class="input input-bordered w-full" required />
                        @error('longitude')<span class="text-error text-sm">{{ $message }}</span>@enderror
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Radius <span class="text-red-500">*</span></span>
                        <input type="number" name="radius" min="0" value="{{ old('radius') }}" placeholder="Radius" class="input input-bordered w-full" required />
                        @error('radius')<span class="text-error text-sm">{{ $message }}</span>@enderror
                    </label>

                    <div class="mb-3">
                        <span class="label-text font-semibold">Is Used? <span class="text-red-500">*</span></span>
                        <label class="cursor-pointer mr-5">
                            <input type="radio" name="is_used" value="1" class="radio" {{ old('is_used') === '1' ? 'checked' : '' }} required /> Iya
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="is_used" value="0" class="radio" {{ old('is_used') === '0' ? 'checked' : '' }} required /> Tidak
                        </label>
                        @error('is_used')<span class="text-error text-sm block">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="btn btn-success w-full mt-3">Simpan</button>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <input type="checkbox" id="edit_button" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box relative">
                <label for="edit_button" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="text-lg font-bold mb-4">Edit Lokasi Kantor</h3>

                <form id="edit_form" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id" />

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Kota <span class="text-red-500">*</span></span>
                        <input type="text" name="kota" id="edit_kota" placeholder="Kota" class="input input-bordered w-full" required />
                        <span class="text-sm text-error" id="error_edit_kota"></span>
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Alamat <span class="text-red-500">*</span></span>
                        <textarea name="alamat" id="edit_alamat" class="textarea textarea-bordered w-full" required></textarea>
                        <span class="text-sm text-error" id="error_edit_alamat"></span>
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Latitude <span class="text-red-500">*</span></span>
                        <input type="text" name="latitude" id="edit_latitude" placeholder="Latitude" class="input input-bordered w-full" required />
                        <span class="text-sm text-error" id="error_edit_latitude"></span>
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Longitude <span class="text-red-500">*</span></span>
                        <input type="text" name="longitude" id="edit_longitude" placeholder="Longitude" class="input input-bordered w-full" required />
                        <span class="text-sm text-error" id="error_edit_longitude"></span>
                    </label>

                    <label class="form-control w-full mb-3">
                        <span class="label-text font-semibold">Radius <span class="text-red-500">*</span></span>
                        <input type="number" name="radius" id="edit_radius" min="0" placeholder="Radius" class="input input-bordered w-full" required />
                        <span class="text-sm text-error" id="error_edit_radius"></span>
                    </label>

                    <div class="mb-3">
                        <span class="label-text font-semibold">Is Used? <span class="text-red-500">*</span></span>
                        <label class="cursor-pointer mr-5">
                            <input type="radio" name="is_used" id="edit_is_used_1" value="1" class="radio" required /> Iya
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="is_used" id="edit_is_used_0" value="0" class="radio" required /> Tidak
                        </label>
                        <span class="text-sm text-error" id="error_edit_is_used"></span>
                    </div>

                    <button type="submit" class="btn btn-success w-full mt-3">Update</button>
                </form>
            </div>
        </div>

        {{-- Tabel Data Lokasi Kantor --}}
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kota</th>
                        <th>Alamat</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Radius</th>
                        <th>Is Used</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lokasis as $index => $lokasi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $lokasi->kota }}</td>
                        <td>{{ $lokasi->alamat }}</td>
                        <td>{{ $lokasi->latitude }}</td>
                        <td>{{ $lokasi->longitude }}</td>
                        <td>{{ $lokasi->radius }}</td>
                        <td>{!! $lokasi->is_used ? '<span class="text-green-600 font-semibold">Iya</span>' : '<span class="text-red-600 font-semibold">Tidak</span>' !!}</td>
                        <td>
                            <button onclick="edit_button({{ $lokasi->id }})" class="btn btn-sm btn-warning mr-2">Edit</button>
                            <button onclick="delete_button({{ $lokasi->id }}, '{{ $lokasi->kota }}')" class="btn btn-sm btn-error">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                    @if($lokasis->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Data lokasi kantor belum tersedia.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function edit_button(id) {
            // Buka modal edit
            document.getElementById('edit_button').checked = true;

            // Reset error messages
            ['kota', 'alamat', 'latitude', 'longitude', 'radius', 'is_used'].forEach(field => {
                document.getElementById('error_edit_' + field).textContent = '';
            });

            fetch(`/admin/lokasi-kantor/${id}/edit`)
                .then(res => {
                    if (!res.ok) throw new Error('Gagal mengambil data.');
                    return res.json();
                })
                .then(data => {
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_kota').value = data.kota;
                    document.getElementById('edit_alamat').value = data.alamat;
                    document.getElementById('edit_latitude').value = data.latitude;
                    document.getElementById('edit_longitude').value = data.longitude;
                    document.getElementById('edit_radius').value = data.radius;

                    if (data.is_used == 1 || data.is_used === true) {
                        document.getElementById('edit_is_used_1').checked = true;
                    } else {
                        document.getElementById('edit_is_used_0').checked = true;
                    }

                    // Set action form update sesuai id
                    const form = document.getElementById('edit_form');
                    form.action = `/admin/lokasi-kantor/${data.id}`;
                })
                .catch(err => {
                    alert('Gagal mengambil data untuk edit.');
                    console.error(err);
                });
        }

        // Submit form edit pakai ajax (optional, kalau mau reload bisa langsung submit form biasa)
        document.getElementById('edit_form').addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('edit_id').value;
            const formData = new FormData(this);

            // Clear error messages
            ['kota', 'alamat', 'latitude', 'longitude', 'radius', 'is_used'].forEach(field => {
                document.getElementById('error_edit_' + field).textContent = '';
            });

            fetch(`/admin/lokasi-kantor/${id}`, {
                    method: 'POST', // karena pakai @method('PUT')
                    headers: {
                        'X-HTTP-Method-Override': 'PUT',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(res => {
                    if (res.status === 422) {
                        return res.json().then(data => {
                            for (const key in data.errors) {
                                if (data.errors.hasOwnProperty(key)) {
                                    const el = document.getElementById('error_edit_' + key);
                                    if (el) el.textContent = data.errors[key][0];
                                }
                            }
                            throw new Error('Validation error');
                        });
                    }
                    if (!res.ok) throw new Error('Update gagal');
                    return res.json();
                })
                .then(() => {
                    alert('Data berhasil diupdate');
                    location.reload();
                })
                .catch(err => {
                    if (err.message !== 'Validation error') {
                        alert(err.message);
                    }
                });
        });

        function delete_button(id, kota) {
            if (confirm(`Apakah Anda yakin ingin menghapus lokasi ${kota}?`)) {
                fetch(`/admin/lokasi-kantor/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal menghapus data');
                        return res.json();
                    })
                    .then(() => {
                        alert('Data berhasil dihapus');
                        location.reload();
                    })
                    .catch(err => {
                        alert(err.message);
                    });
            }
        }
    </script>
</x-app-layout>