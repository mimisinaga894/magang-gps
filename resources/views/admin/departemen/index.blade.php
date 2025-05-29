@extends('layouts.app')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __("Data Departemen") }}
            </h2>
            <label class="btn btn-primary btn-sm" for="create_modal">Tambah Data</label>
        </div>
    </x-slot>

    <div class="container mx-auto px-5 pt-5">
        <!-- Search -->
        <form action="{{ route("admin.departemen") }}" method="get" class="my-3">
            <div class="flex flex-wrap gap-2 md:flex-nowrap">
                <input type="text" name="cari_departemen" placeholder="Pencarian" class="input input-bordered w-full" value="{{ request()->cari_departemen }}" />
                <button type="submit" class="btn btn-success w-full md:w-14">
                    <i class="ri-search-2-line text-lg text-white"></i>
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto rounded-md bg-slate-200 p-4">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departemen as $i => $item)
                    <tr>
                        <td>{{ $departemen->firstItem() + $i }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            <label class="btn btn-warning btn-sm" for="edit_button" onclick="edit_button('{{ $item->id }}')">
                                <i class="ri-pencil-fill"></i>
                            </label>
                            <button class="btn btn-error btn-sm" onclick="delete_button('{{ $item->id }}', '{{ $item->nama }}')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $departemen->links() }}
        </div>
    </div>

    <!-- Modal Create -->
    <input type="checkbox" id="create_modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <form action="{{ route('admin.departemen.store') }}" method="POST">
                @csrf
                <h3 class="font-bold text-lg mb-3">Tambah Departemen</h3>
                <input type="text" name="kode" placeholder="Kode" class="input input-bordered w-full mb-2" required>
                <input type="text" name="nama" placeholder="Nama" class="input input-bordered w-full mb-2" required>
                <div class="modal-action">
                    <label for="create_modal" class="btn btn-neutral">Tutup</label>
                    <button class="btn btn-success text-white" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <input type="checkbox" id="edit_button" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <form action="{{ route('admin.departemen.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <h3 class="font-bold text-lg mb-3">Edit Departemen</h3>
                <input type="text" name="kode" id="edit_kode" placeholder="Kode" class="input input-bordered w-full mb-2" required>
                <input type="text" name="nama" id="edit_nama" placeholder="Nama" class="input input-bordered w-full mb-2" required>
                <div class="modal-action">
                    <label for="edit_button" class="btn btn-neutral">Tutup</label>
                    <button class="btn btn-warning text-white" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function edit_button(id) {
            $.get("{{ route('admin.departemen.edit') }}", {
                id: id
            }, function(data) {
                $('#edit_id').val(data.id);
                $('#edit_kode').val(data.kode);
                $('#edit_nama').val(data.nama);
            });
        }

        function delete_button(id, nama) {
            Swal.fire({
                title: 'Hapus Departemen?',
                text: "Data " + nama + " akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('admin.departemen.delete') }}", {
                        _token: '{{ csrf_token() }}',
                        id: id
                    }, function(response) {
                        Swal.fire('Terhapus!', response.message, 'success').then(() => location.reload());
                    });
                }
            });
        }
    </script>
</x-app-layout>
@endsection