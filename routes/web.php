<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\role_menu;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'pagelogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout',  [ AuthController::class,'logout'])->name('logout');

Route::get('/Welcome', [AdminController::class, 'Welcome'])->name('Welcome');

Route::get('/Dashboard', [AdminController::class, 'Dashboard'])->name('Dashboard');

Route::middleware(['auth', role_menu::class . ':Role'])->group(function () {
    Route::post('/role', [RoleController::class,'store'])->name('store.role');
    Route::get('/role', [RoleController::class,'index'])->name('index.role');
    Route::delete('/role/{id}', [RoleController::class,'destroy'])->name('role.destroy');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('update.role');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('edit.role');
});

Route::middleware(['auth', role_menu::class . ':Menu'])->group(function () {
    Route::get('/menu', [MenuController::class,'index'])->name('index.menu');
    Route::post('/menu', [MenuController::class,'store'])->name('store.menu');
    Route::delete('/menu/{id}', [MenuController::class,'destroy'])->name('menu.destroy');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('update.menu');
});

Route::middleware(['auth', role_menu::class . ':Permission'])->group(function () {
    Route::get('/permission', [PermissionController::class, 'permission'])->name('permission');
    Route::put('/permissions/{role_id}', [PermissionController::class, 'update'])->name('permissions.update');
});

Route::middleware(['auth', role_menu::class . ':Hak-Akses'])->group(function () {
    Route::get('/hakakses', [HakAksesController::class, 'hakakses'])->name('hakakses');
    Route::get('/hakaksesrole', [HakAksesController::class, 'hakaksesrole'])->name('hakaksesrole');
    Route::put('/update-access/{role_id}', [HakAksesController::class, 'updaterole'])->name('update.access');
});
