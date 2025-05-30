<?php

namespace App\Http\Controllers;

use App\Models\LokasiKantor;
use Illuminate\Http\Request;

class LokasiKantorController extends Controller
{
    public function index()
    {
        $lokasiKantor = LokasiKantor::paginate(10);
        return view('admin.lokasi-kantor.index', compact('lokasiKantor'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kota' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            'is_used' => 'required|boolean'
        ]);

        if ($data['is_used']) {
            LokasiKantor::where('is_used', true)->update(['is_used' => false]);
        }

        LokasiKantor::create($data);
        return redirect()->route('admin.lokasi-kantor.index')->with('success', 'Lokasi kantor berhasil ditambahkan');
    }

    public function update(Request $request, LokasiKantor $lokasiKantor)
    {
        $data = $request->validate([
            'kota' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            'is_used' => 'required|boolean'
        ]);

        if ($data['is_used']) {
            LokasiKantor::where('is_used', true)->update(['is_used' => false]);
        }

        $lokasiKantor->update($data);
        return redirect()->route('admin.lokasi-kantor.index')->with('success', 'Lokasi kantor berhasil diperbarui');
    }

    public function destroy(LokasiKantor $lokasiKantor)
    {
        if (LokasiKantor::count() <= 1) {
            return back()->with('error', 'Minimal harus ada satu lokasi kantor');
        }

        $lokasiKantor->delete();
        return redirect()->route('admin.lokasi-kantor.index')->with('success', 'Lokasi kantor berhasil dihapus');
    }
}
