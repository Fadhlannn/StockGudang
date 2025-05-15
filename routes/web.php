<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\role_menu;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\SparepartContolller;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataKeluarController;
use App\Http\Controllers\DataMasukController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\PengemudiController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\SupliersController;
use App\Models\Mekanik;

Route::get('/', [AuthController::class, 'pagelogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout',  [ AuthController::class,'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class,'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/Welcome', [AdminController::class, 'Welcome'])->name('Welcome');
});

Route::get('password/reset', [ResetPasswordController::class, 'showResetRequestForm'])->name('password.request');
Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth', role_menu::class . ':Role'])->group(function () {
    Route::post('/role', [RoleController::class,'store'])->name('store.role');
    Route::get('/role', [RoleController::class,'index'])->name('index.role');
    Route::delete('/role/{id}', [RoleController::class,'destroy'])->name('role.destroy');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('update.role');
});

Route::middleware(['auth', role_menu::class . ':Menu'])->group(function () {
    Route::get('/menu', [MenuController::class,'index'])->name('index.menu');
    Route::post('/menu', [MenuController::class,'store'])->name('store.menu');
    Route::delete('/menu/{id}', [MenuController::class,'destroy'])->name('menu.destroy');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('update.menu');
});

Route::middleware(['auth', role_menu::class . ':Permission'])->group(function () {
    Route::get('/permission', [PermissionController::class, 'index'])->name('konfigurasi.permission');
    Route::delete('/permission/{id}', [PermissionController::class,'destroy'])->name('permission.destroy');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('update.permission');
    Route::post('/permission', [PermissionController::class,'store'])->name('store.permission');
});

Route::middleware(['auth', role_menu::class . ':Hak-Akses'])->group(function () {
    Route::get('/hakakses', [HakAksesController::class, 'hakakses'])->name('hakakses');
    Route::get('/hakaksesrole', [HakAksesController::class, 'hakaksesrole'])->name('hakaksesrole');
    Route::put('/update-access/{role_id}', [HakAksesController::class, 'updaterole'])->name('update.access');
    Route::delete('/hak-akses/{id}', [HakAksesController::class,'destroy'])->name('hakakses.destroy');
    Route::put('/hak-akses/{id}', [HakAksesController::class, 'update'])->name('update.user');
    Route::post('/hak-akses', [HakAksesController::class,'store'])->name('store.user');
});

Route::middleware(['auth', role_menu::class . ':Sparepart'])->group(function () {
    Route::get('/Sparepart', [SparepartContolller::class, 'index'])->name('Sparepart');
    Route::post('/Sparepart', [SparepartContolller::class, 'store'])->name('store.sparepart');
    Route::delete('/Sparepart/{id}', [SparepartContolller::class,'destroy'])->name('sparepart.destroy');
    Route::put('/Sparepart/{id}', [SparepartContolller::class, 'update'])->name('update.sparepart');

});

Route::middleware(['auth', role_menu::class . ':Riwayat'])->group(function () {
    Route::get('/Riwayat', [RiwayatController::class, 'index'])->name('Riwayat');
    Route::get('/riwayat/export-pdf', [RiwayatController::class, 'exportPDF'])->name('riwayat.export-pdf');
});

Route::middleware(['auth', role_menu::class . ':Stok'])->group(function () {
    Route::get('/stok', [StockController::class, 'index'])->name('stok.index');
});

Route::get('/DataMasuk', [DataMasukController::class, 'index'])->name('DataMasuk');
Route::post('/DataMasuk', [DataMasukController::class, 'store'])->name('dataMasuk.store');
Route::get('/DataMasuk/{dataMasuk}/edit', [DataMasukController::class, 'edit'])->name('dataMasuk.edit');
Route::put('/DataMasuk/{dataMasuk}', [DataMasukController::class, 'update'])->name('dataMasuk.update');
Route::delete('/DataMasuk/{dataMasuk}', [DataMasukController::class, 'destroy'])->name('dataMasuk.destroy');
Route::get('/get-spareparts', [DataMasukController::class, 'getSpareparts'])->name('getSparepart');
Route::get('/rekap-total-order/{no_order?}', [DataMasukController::class, 'rekapTotalOrder'])->name('rekapTotalOrder');
;



Route::get('/Spk',[SpkController::class,'index'])->name('Spk');
Route::post('/Spk',[SpkController::class,'store'])->name('spk.store');
Route::get('/Spk/{spk}/edit',[SpkController::class,'edit'])->name('spk.edit');
Route::put('/Spk/{spk}',[SpkController::class,'update'])->name('spk.update');
Route::delete('/Spk/{spk}',[SpkController::class,'destroy'])->name('spk.destroy');
Route::get('/get-nip-pengemudi', [SpkController::class, 'getNipPengemudi'])->name('get-nip-pengemudi');
Route::get('/get-route-polisi', [SpkController::class, 'getRoutePolisi'])->name('get-route-polisi');

Route::get('/spk/{id}/data-keluar', [DataKeluarController::class, 'dataKeluar'])->name('dataKeluar');
Route::post('/spk/{spk}/data-keluar', [DataKeluarController::class, 'store'])->name('data-keluar.store');
Route::get('/get-spareparts', [DataKeluarController::class, 'getSpareparts']);


Route::get('/bus', [BusController::class, 'index'])->name('Bus');
Route::post('/bus', [BusController::class, 'store'])->name('bus.store');
Route::put('/bus/{id}/update', [BusController::class, 'update'])->name('bus.update');
Route::delete('/bus/{bus}', [BusController::class, 'destroy'])->name('bus.destroy');


Route::get('/Pengemudi', [PengemudiController::class, 'index'])->name('Pengemudi');
Route::post('/Pengemudi', [PengemudiController::class, 'store'])->name('pengemudi.store');
Route::put('/Pengemudi/{id}/update', [PengemudiController::class, 'update'])->name('pengemudi.update');
Route::delete('/Pengemudi/{id}', [PengemudiController::class, 'destroy'])->name('pengemudi.destroy');

Route::get('/Route', [RouteController::class, 'index'])->name('Route');
Route::post('/Route', [RouteController::class, 'store'])->name('route.store');
Route::put('/routes/{id}', [RouteController::class, 'update'])->name('route.update');
Route::delete('/routes/{id}', [RouteController::class, 'destroy'])->name('route.destroy');


Route::get('/Mekanik', [MekanikController::class, 'index'])->name('Mekanik');
Route::post('/Mekanik', [MekanikController::class, 'store'])->name('mekanik.store');
Route::put('/Mekanik/{id}', [MekanikController::class, 'update'])->name('mekanik.update');
Route::delete('/Mekanik/{id}', [MekanikController::class, 'destroy'])->name('mekanik.destroy');

Route::get('/Supliers', [SupliersController::class, 'index'])->name('Supliers');
Route::post('/Supliers', [SupliersController::class, 'store'])->name('suplier.store');
Route::put('/Supliers/{id}', [SupliersController::class, 'update'])->name('suplier.update');
Route::delete('/Supliers/{id}', [SupliersController::class, 'destroy'])->name('suplier.destroy');
