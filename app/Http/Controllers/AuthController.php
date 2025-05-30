<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        $departemens = \App\Models\Departemen::all();
        return view('auth.register', compact('departemens'));
    }

    public function register(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'gender' => 'required|in:L,P',
                'phone' => 'nullable|string|max:15',
                'address' => 'nullable|string',
                'departemen_id' => 'required|exists:departemen,id',
                'jabatan' => 'required|string|max:50',
                'password' => 'required|min:6|confirmed'
            ], [
                'name.required' => 'Nama lengkap wajib diisi',
                'username.required' => 'Username wajib diisi',
                'username.unique' => 'Username sudah digunakan',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'gender.required' => 'Jenis kelamin wajib dipilih',
                'departemen_id.required' => 'Departemen wajib dipilih',
                'departemen_id.exists' => 'Departemen tidak valid',
                'jabatan.required' => 'Jabatan wajib diisi',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok'
            ]);

            DB::beginTransaction();

            try {
                // Create user
                $user = User::create([
                    'name' => $validated['name'],
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'karyawan',
                ]);

                // Create karyawan
                Karyawan::create([
                    'user_id' => $user->id,
                    'nik' => 'K' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                    'departemen_id' => $validated['departemen_id'],
                    'nama_lengkap' => $validated['name'],
                    'jabatan' => $validated['jabatan']
                ]);

                DB::commit();
                Auth::login($user);

                return redirect()->route($user->role . '.dashboard')
                    ->with('success', 'Registrasi berhasil! Selamat datang.');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Registration Error:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return back()
                    ->withInput()
                    ->withErrors(['error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.']);
            }
        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors());
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ], [
                'username.required' => 'Username wajib diisi',
                'password.required' => 'Password wajib diisi'
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route(Auth::user()->role . '.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . Auth::user()->name);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Username atau password salah']);
        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Login Error:', [
                'message' => $e->getMessage(),
                'user' => $request->username
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat login. Silakan coba lagi.']);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('success', 'Berhasil logout.');
        } catch (\Exception $e) {
            \Log::error('Logout Error:', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()->route('login')
                ->withErrors(['error' => 'Terjadi kesalahan saat logout.']);
        }
    }
}
