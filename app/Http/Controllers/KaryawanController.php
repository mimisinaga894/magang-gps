<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    // Dashboard karyawan (contoh)
    public function showDashboard()
    {
        $absensis = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('karyawan.dashboard', compact('absensis'));
    }

    // Absen Masuk (tanpa validasi lokasi)
    public function absenMasuk(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $tanggal = Carbon::now()->toDateString();
        $waktuSekarang = Carbon::now()->toTimeString();

        // Cek sudah absen masuk hari ini
        $absenHariIni = Absensi::where('user_id', $user->id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($absenHariIni) {
            return back()->with('info', 'Anda sudah melakukan absen masuk hari ini.');
        }

        // Cek status keterlambatan
        $status = Carbon::now()->gt(Carbon::createFromTime(8, 0, 0)) ? 'telat' : 'hadir';

        // Simpan absen masuk
        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $tanggal,
            'jadwal_masuk' => '08:00:00',
            'jadwal_pulang' => '16:30:00',
            'jam_masuk' => $waktuSekarang,
            'status' => $status,
            'latitude_masuk' => $request->latitude,
            'longitude_masuk' => $request->longitude,
        ]);

        return back()->with('success', 'Absen masuk berhasil.');
    }

    // Absen Pulang (tanpa validasi lokasi)
    public function absenPulang(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $tanggal = Carbon::now()->toDateString();
        $waktuSekarang = Carbon::now()->toTimeString();

        // Cari data absen hari ini
        $absenHariIni = Absensi::where('user_id', $user->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$absenHariIni) {
            return back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
        }

        if ($absenHariIni->jam_pulang) {
            return back()->with('info', 'Anda sudah melakukan absen pulang hari ini.');
        }

        // Update absen pulang
        $absenHariIni->update([
            'jam_pulang' => $waktuSekarang,
            'latitude_pulang' => $request->latitude,
            'longitude_pulang' => $request->longitude,
        ]);

        return back()->with('success', 'Absen pulang berhasil.');
    }
}
