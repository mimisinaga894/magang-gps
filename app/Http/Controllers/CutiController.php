<?php


namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CutiController extends Controller
{
    public function create()
    {
        return view('cuti.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_cuti' => 'required|string',
            'alasan' => 'nullable|string'
        ]);

        Cuti::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis_cuti' => $request->jenis_cuti,
            'alasan' => $request->alasan,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
}
