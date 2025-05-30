<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Absensi;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $today = Carbon::today();

        $departemenData = Departemen::withCount(['karyawan as hadir_count' => function ($query) use ($today) {
            $query->whereHas('absensi', function ($q) use ($today) {
                $q->whereDate('tanggal', $today)->where('status', 'hadir');
            });
        }, 'karyawan as telat_count' => function ($query) use ($today) {
            $query->whereHas('absensi', function ($q) use ($today) {
                $q->whereDate('tanggal', $today)->where('status', 'telat');
            });
        }])->get();

        $weeklyAbsensi = Absensi::whereBetween('tanggal', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
            ->selectRaw('DATE(tanggal) as date, 
                        COUNT(CASE WHEN status = "hadir" THEN 1 END) as hadir_count,
                        COUNT(CASE WHEN status = "telat" THEN 1 END) as telat_count')
            ->groupBy('date')
            ->get();

        return view('admin.dashboard', compact('departemenData', 'weeklyAbsensi'));
    }

    public function dataKaryawan()
    {
        $karyawan = Karyawan::with(['user', 'departemen'])->get();
        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function dataDepartemen()
    {
        $departemen = Departemen::withCount('karyawan')->get();
        return view('admin.departemen.index', compact('departemen'));
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
