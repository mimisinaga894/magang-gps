<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    // Menampilkan form registrasi
    public function register(Request $request)
    {
        \Log::info('Registrasi data:', $request->all());

        // Validasi input dan simpan ke variabel
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|in:admin,karyawan',
        ]);

        // Simpan data pengguna baru
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'];
        $user->save();

        Auth::login($user);

        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('karyawan.dashboard');
    }



    // Proses login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {


            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'karyawan') {
                return redirect()->route('karyawan.dashboard');
            }
        } else {

            return back()->withErrors(['username' => 'Username atau password salah.']);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Callback untuk Google Login
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'password' => bcrypt(str()->random(24)),
            'role' => 'karyawan',
        ]);

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'karyawan') {
            return redirect()->route('karyawan.dashboard');
        }
    }
}
