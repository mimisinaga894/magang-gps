<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $today = Carbon::today();
        $users = User::all();
        $departemens = Departemen::all();

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
            'weeklyAbsensi',
            'departemens'
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
        try {
            $user = User::findOrFail($id);

            $rules = [
                'name' => 'required|max:255',
                'username' => 'required|unique:users,username,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'gender' => 'nullable|in:L,P',
                'phone' => 'nullable|max:15',
                'address' => 'nullable',
                'role' => 'required|in:admin,karyawan'
            ];

            // Tammbahkan aturan jika role diubah menjadi karyawan
            if ($request->input('role') === 'karyawan') {
                $rules = array_merge($rules, [
                    'nik' => 'required|unique:karyawan,nik,' . ($user->karyawan->id ?? ''),
                    'departemen_id' => 'required|exists:departemen,id',
                    'jabatan' => 'required|max:50'
                ]);
            }

            $messages = [
                'name.required' => 'Nama lengkap wajib diisi',
                'username.required' => 'Username wajib diisi',
                'username.unique' => 'Username sudah digunakan',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi',
                'role.required' => 'Role wajib dipilih',
                'nik.required' => 'NIK wajib diisi',
                'nik.unique' => 'NIK sudah digunakan',
                'nik.min' => 'NIK harus 16 karakter',
                'nik.max' => 'NIK harus 16 karakter',
                'departemen_id.required' => 'Departemen wajib dipilih',
                'jabatan.required' => 'Jabatan wajib diisi'
            ];


            try {
                $validated = $request->validate($rules, $messages);

                DB::beginTransaction();

                // Update user data
                $user->update([
                    'name' => $validated['name'],
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'role' => $validated['role']
                ]);

                // Jika role adalah karyawan, pastikan NIK, departemen, dan jabatan diisi
                if ($validated['role'] === 'karyawan') {
                    // Buat atau update data karyawan
                    if ($user->karyawan) {
                        $user->karyawan->update([
                            'nik' => $validated['nik'],
                            'departemen_id' => $validated['departemen_id'],
                            'nama_lengkap' => $validated['name'],
                            'jabatan' => $validated['jabatan']
                        ]);
                    } else {
                        // Tambah data karyawan
                        Karyawan::create([
                            'user_id' => $user->id,
                            'nik' => $validated['nik'],
                            'departemen_id' => $validated['departemen_id'],
                            'nama_lengkap' => $validated['name'],
                            'jabatan' => $validated['jabatan']
                        ]);
                    }
                } else {
                    // Jika role diubah dari karyawan ke admin, hapus data karyawan
                    if ($user->karyawan) {
                        $user->karyawan->delete();
                    }
                }

                DB::commit();
                return redirect()
                    ->route('admin.dashboard')
                    ->with('success', 'Data pengguna berhasil diperbarui');
            } catch (\Illuminate\Validation\ValidationException $e) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->withErrors($e->validator)
                    ->withInput();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Update user error:', [
                    'user_id' => $id,
                    'error' => $e->getMessage()
                ]);
                return redirect()
                    ->back()
                    ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Pengguna tidak ditemukan.')
                ->withInput();
        }
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
