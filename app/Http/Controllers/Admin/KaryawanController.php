<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Departemen;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with(['user', 'departemen'])->paginate(10);
        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('karyawan')->get();
        $departemen = Departemen::all();
        return view('admin.karyawan.create', compact('users', 'departemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:karyawan',
            'user_id' => 'required',
            'departemen_id' => 'required',
            'jabatan' => 'required',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $users = User::all();
        $departemen = Departemen::all();
        return view('admin.karyawan.edit', compact('karyawan', 'users', 'departemen'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:karyawan,nik,' . $id,
            'user_id' => 'required',
            'departemen_id' => 'required',
            'jabatan' => 'required',
        ]);

        $karyawan->update($request->all());

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
