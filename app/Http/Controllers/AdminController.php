<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class AdminController extends Controller
{


    public function showDashboard()
    {

        $users = User::all();

        return view('admin.dashboard', compact('users'));
    }

    public function index()
    {
        $today = Carbon::today();

        $departemenData = DB::table('departemen as d')
            ->leftJoin('karyawan as k', 'k.id_departemen', '=', 'd.id_departemen')
            ->leftJoin('absensi as a', function ($join) use ($today) {
                $join->on('a.id_karyawan', '=', 'k.id_karyawan')
                    ->whereDate('a.tanggal_absensi', $today);
            })
            ->select(
                'd.nama_departemen',
                DB::raw('COUNT(k.id_karyawan) as jumlah_karyawan'),
                DB::raw("SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END) as jumlah_hadir"),
                DB::raw("SUM(CASE WHEN a.status = 'Sakit' THEN 1 ELSE 0 END) as jumlah_sakit"),
                DB::raw("SUM(CASE WHEN a.status = 'Izin' THEN 1 ELSE 0 END) as jumlah_izin")
            )
            ->groupBy('d.id_departemen')
            ->get();

        // Data absensi mingguan untuk chart
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $weeklyAbsensi = DB::table('absensi')
            ->select(
                DB::raw('DATE(tanggal_absensi) as tanggal'),
                DB::raw("SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as izin")
            )
            ->whereBetween('tanggal_absensi', [$weekStart, $weekEnd])
            ->groupBy(DB::raw('DATE(tanggal_absensi)'))
            ->orderBy('tanggal')
            ->get();

        // Ambil data untuk chart
        $labels = $weeklyAbsensi->pluck('tanggal')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });

        $hadirData = $weeklyAbsensi->pluck('hadir');
        $sakitData = $weeklyAbsensi->pluck('sakit');
        $izinData = $weeklyAbsensi->pluck('izin');

        $users = DB::table('users')->get();

        return view('admin.dashboard', compact(
            'departemenData',
            'weeklyAbsensi',
            'users',
            'labels',
            'hadirData',
            'sakitData',
            'izinData'
        ));
    }


    public function dataKaryawan()
    {

        $karyawan = Karyawan::all();


        return view('admin.dataKaryawan', compact('karyawan'));
    }


    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function dataDepartemen()
    {
        $departemen = Departemen::all();

        return view('admin.dataDepartemen', compact('departemen'));
    }



    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,karyawan',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil diperbarui.');
    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus.');
    }
}
