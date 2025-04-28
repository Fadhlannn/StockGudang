<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan form register (jika pakai web.php)
    public function showRegistrationForm()
    {
        $role = Role::all();
        return view('auth.register', compact('role')); // Pastikan file auth/register.blade.php ada
    }

    // Menangani proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nip' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:15',
            'role_id' => 'required|exists:role,id', // Pastikan role_id valid dan ada di tabel roles
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'role_id' => $request->role_id, // Mendapatkan role_id dari form
        ]);

        // Redirect ke halaman home atau dashboard
        return redirect('/')->with('success', 'Registrasi berhasil!');
    }
}
