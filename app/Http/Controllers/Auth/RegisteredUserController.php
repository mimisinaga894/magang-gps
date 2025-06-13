<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{

    public function create(): View
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'gender' => 'required|in:L,P',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'role' => 'required|in:admin,karyawan',
            'nik' => 'nullable|string|max:50',
            'departemen_id' => 'nullable|exists:departemens,id',
            'jabatan' => 'nullable|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => $validated['role'],
            'nik' => $validated['nik'] ?? null,
            'departemen_id' => $validated['departemen_id'] ?? null,
            'jabatan' => $validated['jabatan'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);


        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
