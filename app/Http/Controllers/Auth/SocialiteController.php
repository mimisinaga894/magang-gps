<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    public function redirect()
    {
        try {
            return Socialite::driver('google')
                ->with(['prompt' => 'select_account'])
                ->redirect();
        } catch (Exception $e) {
            Log::error('Google redirect failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/login')->withErrors('Tidak dapat terhubung dengan Google.');
        }
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $userData = $googleUser->getRaw();

            // Generate name and username
            $fullName = trim($userData['given_name'] . ' ' . $userData['family_name']);
            $username = $googleUser->name;

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            \DB::beginTransaction();
            try {
                if (!$user) {
                    Log::info('Creating new user from Google', [
                        'name' => $fullName,
                        'email' => $googleUser->email
                    ]);

                    $user = User::create([
                        'name' => $fullName,
                        'username' => $username,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                        'password' => Hash::make(uniqid()),
                        'role' => 'karyawan',
                        'gender' => 'L',
                        'email_verified_at' => now(),
                    ]);

                    // Create associated Karyawan record
                    $karyawan = \App\Models\Karyawan::create([
                        'user_id' => $user->id,
                        'nik' => 'K' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                        'departemen_id' => 1,
                        'nama_lengkap' => $fullName,
                        'jabatan' => 'Staff'
                    ]);

                    Log::info('Created karyawan record', ['karyawan_id' => $karyawan->id]);
                }

                \DB::commit();
                Auth::login($user, true);

                return redirect()->intended(route($user->role . '.dashboard'))
                    ->with('success', 'Berhasil login dengan Google.');
            } catch (\Exception $e) {
                \DB::rollBack();
                Log::error('Failed to create user/karyawan', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Google callback failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/login')
                ->withErrors('Login dengan Google gagal. Silakan coba lagi.');
        }
    }
}
