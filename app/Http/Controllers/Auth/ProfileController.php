<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan form pengaturan akun untuk pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */


    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('admin.pengaturan-akun', compact('user'));
    }

    /**
     * Memperbarui data akun pengguna yang sedang login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.pengaturan-akun')->with('success', 'Akun berhasil diperbarui!');
    }
}
