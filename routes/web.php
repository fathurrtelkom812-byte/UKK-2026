<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama / Landing Page
Route::get('/', function () {
    // Pengaman: Jika admin tersesat di sesi web, paksa logout
    if (Auth::check() && Auth::user()->role === 'admin') {
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Akun Administrator tidak diizinkan mengakses halaman siswa.'
        ]);
    }
    
    return redirect()->route('pengaduan.index');
})->name('home');

// Rute Autentikasi Siswa (Login & Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute khusus untuk Siswa yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/pengaduan', [PengaduanUserController::class, 'index'])->name('pengaduan.index');
    
    // RUTE YANG SEBELUMNYA HILANG:
    Route::post('/pengaduan', [PengaduanUserController::class, 'store'])->name('pengaduan.store');
});