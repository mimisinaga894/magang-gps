<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
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
            $rules = [
                'name' => 'required|max:255',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'gender' => 'required|in:L,P',
                'phone' => 'required|max:15',
                'address' => 'required',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required',
                'nik' => 'required|unique:karyawan|min:16|max:16',
                'departemen_id' => 'required|exists:departemen,id',
                'jabatan' => 'required|max:50'
            ];

            $messages = [
                'name.required' => 'Nama lengkap wajib diisi',
                'username.required' => 'Username wajib diisi',
                'username.unique' => 'Username sudah digunakan',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'gender.required' => 'Jenis kelamin wajib dipilih',
                'phone.required' => 'Nomor telepon wajib diisi',
                'phone.max' => 'Nomor telepon maksimal 15 digit',
                'address.required' => 'Alamat wajib diisi',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi',
                'nik.required' => 'NIK wajib diisi',
                'nik.unique' => 'NIK sudah digunakan',
                'nik.min' => 'NIK harus 16 karakter',
                'nik.max' => 'NIK harus 16 karakter',
                'departemen_id.required' => 'Departemen wajib dipilih',
                'jabatan.required' => 'Jabatan wajib diisi'
            ];

            $validated = $request->validate($rules, $messages);

            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'password' => Hash::make($validated['password']),
                'role' => 'karyawan'
            ]);

            Karyawan::create([
                'user_id' => $user->id,
                'nik' => $validated['nik'],
                'departemen_id' => $validated['departemen_id'],
                'nama_lengkap' => $validated['name'],
                'jabatan' => $validated['jabatan']
            ]);

            DB::commit();

            Auth::login($user);
            return redirect()->route('karyawan.dashboard')->with('success', 'Registrasi berhasil!');
        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Register Error:', ['message' => $e->getMessage()]);
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat registrasi.']);
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

    public function showRegisterForm()
    {
        $departemens = Departemen::all();
        return view('auth.register', compact('departemens'));
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
