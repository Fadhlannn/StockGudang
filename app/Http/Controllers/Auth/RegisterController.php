<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan form register (jika pakai web.php)
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan file auth/register.blade.php ada
    }

    // Menangani proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Ambil role "user" (pastikan role user ada di tabel roles)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        // Redirect ke halaman home atau dashboard
        return redirect('/')->with('success', 'Registrasi berhasil!');
    }
}
