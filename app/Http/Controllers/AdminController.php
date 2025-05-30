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
        $users = User::all();

        $departemenData = Departemen::select('id', 'nama as nama_departemen')
            ->withCount(['karyawan as jumlah_karyawan'])
            ->withCount(['karyawan as jumlah_hadir' => function ($query) use ($today) {
                $query->whereHas('absensi', function ($q) use ($today) {
                    $q->whereDate('tanggal', $today)
                        ->where('status', 'hadir');
                });
            }])
            ->withCount(['karyawan as jumlah_sakit' => function ($query) use ($today) {
                $query->whereHas('absensi', function ($q) use ($today) {
                    $q->whereDate('tanggal', $today)
                        ->where('status', 'sakit');
                });
            }])
            ->withCount(['karyawan as jumlah_izin' => function ($query) use ($today) {
                $query->whereHas('absensi', function ($q) use ($today) {
                    $q->whereDate('tanggal', $today)
                        ->where('status', 'izin');
                });
            }])
            ->get();

        $weeklyAbsensi = Absensi::whereBetween('tanggal', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
            ->selectRaw('
            DATE(tanggal) as date,
            COUNT(CASE WHEN status = "hadir" THEN 1 END) as hadir_count,
            COUNT(CASE WHEN status = "sakit" THEN 1 END) as sakit_count,
            COUNT(CASE WHEN status = "izin" THEN 1 END) as izin_count
        ')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('l'),
                    'hadir' => $item->hadir_count,
                    'sakit' => $item->sakit_count,
                    'izin' => $item->izin_count
                ];
            });

        return view('admin.dashboard', compact(
            'users',
            'departemenData',
            'weeklyAbsensi'
        ));
    }

    public function dataKaryawan()
    {
        $karyawan = Karyawan::with(['user', 'departemen'])->get();
        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $departemens = Departemen::all();
        return view('admin.edit-user', compact('user', 'departemens'));
    }

    public function dataDepartemen()
    {
        $departemen = Departemen::withCount('karyawan')->get();
        return view('admin.departemen.index', compact('departemen'));
    }

    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'role' => 'required|in:admin,karyawan'
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
                return redirect()
                    ->route('admin.dashboard')
                    ->with('error', 'Tidak dapat menghapus admin terakhir');
            }

            $user->delete();

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Gagal menghapus pengguna');
        }
    }
}
