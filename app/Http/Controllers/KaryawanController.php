<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KaryawanController extends Controller
{

    public function showDashboard()
    {
        $user = Auth::user();
        $karyawan = Karyawan::where('user_id', $user->id)->first();
        $karyawan = Karyawan::where('user_id', $user->id)->first();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('karyawan.dashboard', compact('absensi'));
    }


    protected function handleAbsensi(Request $request, string $type)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            if ($type === 'masuk') {
                $request->validate([
                    'status' => 'required|in:Hadir,Izin,Cuti,Sakit'
                ]);
            }

            $karyawan = Karyawan::where('user_id', auth()->id())->firstOrFail();
            $now = Carbon::now();

            if ($type === 'pulang') {
                return $this->handleAbsenPulang($karyawan, $request, $now);
            }

            return $this->handleAbsenMasuk($karyawan, $request, $now);
        } catch (\Exception $e) {
            \Log::error("Absen {$type} Error:", [
                'message' => $e->getMessage(),
                'user_id' => auth()->id(),
                'data' => $request->all()
            ]);

            return back()->with('error', 'Gagal melakukan absensi. Pastikan GPS aktif dan izinkan akses lokasi.');
        }
    }


    protected function handleAbsenMasuk($karyawan, $request, $now)
    {
        $exists = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $now)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Sudah absen masuk hari ini');
        }

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $now,
            'jam_masuk' => $now,
            'latitude_masuk' => $request->latitude,
            'longitude_masuk' => $request->longitude,
            'status' => $now->gt(Carbon::createFromTime(8, 0)) ? 'telat' : 'hadir'
        ]);

        return back()->with('success', 'Absen masuk berhasil');
    }


    protected function handleAbsenPulang($karyawan, $request, $now)
    {
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $now)
            ->whereNull('jam_pulang')
            ->first();

        if (!$absensi) {
            return back()->with('error', $absensi === null ? 'Belum absen masuk hari ini' : 'Sudah absen pulang hari ini');
        }

        $absensi->update([
            'jam_pulang' => $now,
            'latitude_pulang' => $request->latitude,
            'longitude_pulang' => $request->longitude
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }

    // Routes untuk absensi
    public function absenMasuk(Request $request)
    {
        return $this->handleAbsensi($request, 'masuk');
    }

    public function absenPulang(Request $request)
    {
        return $this->handleAbsensi($request, 'pulang');
    }

    public function lokasiKantor()
    {
        return view('shared.lokasi-kantor');
    }
}
