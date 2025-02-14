<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    function pagelogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        Session::flash('email', $request->email);
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infologin)) {
            return redirect()->route('Welcome')->with('success', 'Selamat Datang, ');
        } else {
            return redirect('/')->withErrors(['loginError' => 'Username dan password yang dimasukkan tidak valid']);
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/')->with('success','Log Out Berhasil');
    }

}
