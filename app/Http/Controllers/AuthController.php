<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun belum terdaftar, silakan register terlebih dahulu.',
            ])->onlyInput('email');
        }

        // PENGAMANAN: Jika akun ber-role admin mencoba login di form siswa, tolak!
        if ($user->role === 'admin') {
            return back()->withErrors([
                'email' => 'Akun Administrator harus login melalui halaman khusus Admin (/admin).',
            ])->onlyInput('email');
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->route('pengaduan.index');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'          => 'required|string|max:255',
            'nis'           => 'required|string|unique:users,nis',
            'kelas'         => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:6|confirmed'
        ], [
            'nis.unique'    => 'NIS ini sudah terdaftar atas nama siswa lain.',
            'email.unique'  => 'Email ini sudah terdaftar, silakan gunakan email lain.'
        ]);

        $user = User::create([
            'name'          => $request->name,
            'nis'           => $request->nis,
            'kelas'         => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'siswa', // Otomatis diset sebagai siswa
        ]);

        Auth::login($user);

        return redirect()->route('pengaduan.index')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}