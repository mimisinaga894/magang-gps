<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jadwalkerja;
use App\Models\Karyawan;

class JadwalKerjaController extends Controller
{
    public function index()
    {
        $jadwal = jadwalkerja::with('karyawan')->latest()->get();
        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('admin.jadwal.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'shift' => 'required|in:pagi,siang,malam',
        ]);

        jadwalkerja::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal kerja berhasil ditambahkan.');
    }
}
