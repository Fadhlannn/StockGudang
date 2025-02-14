<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function Dashboard(){
        return view('Dashboard');
    }
    function menu(){
        return view('konfigurasi.menu');
    }
    function role(){
        return view('konfigurasi.role');
    }
    function permission(){
        return view('konfigurasi.permission');
    }
    function Welcome(){
        return view('Welcome');
    }
}
