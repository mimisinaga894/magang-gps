<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Karyawan;

class AuthController extends Controller
{
    // Menampilkan form registrasi
    public function register(Request $request)
    {
        // Validasi input dan simpan ke variabel
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,karyawan',
        ]);

        DB::beginTransaction();
        // Simpan data pengguna baru
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        // Create karyawan record
        if ($validated['role'] === 'karyawan') {
            $karyawan = Karyawan::create([
                'user_id' => $user->id,
                'nik' => 'K' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'departemen_id' => $validated['departemen_id'],
                'nama_lengkap' => $validated['name'],
                'jabatan' => $validated['jabatan']
            ]);
        }

        DB::commit();
        Auth::login($user);

        return redirect()->route($user->role . '.dashboard')
            ->with('success', 'Registrasi berhasil!');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route(Auth::user()->role . '.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
