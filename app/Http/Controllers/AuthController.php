<?php

// File: app/Http/Controllers/AuthController.php
// Controller untuk menangani autentikasi pengguna (login, register, logout)

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Services\StreakService;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses login pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login dengan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan (mencegah session fixation)
            $request->session()->regenerate();
            
            // Update streak setelah login berhasil (mengecek dan memperbarui streak harian)
            StreakService::update(Auth::user());
            
            // Redirect ke halaman yang dimaksud (dashboard) atau default
            return redirect()->intended('dashboard')->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan halaman form registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Email harus unik di tabel users
            'password' => 'required|string|min:8|confirmed', // Password minimal 8 karakter dan harus terkonfirmasi
        ]);

        // Buat user baru di database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hash password sebelum disimpan
            'streak' => 1, // Langsung set streak 1 untuk user baru (hari pertama)
            'last_login_date' => now(), // Set last login ke waktu sekarang
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang di EduTrack.');
    }

    /**
     * Memproses logout pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();
        
        // Invalidasi session
        $request->session()->invalidate();
        
        // Regenerasi token CSRF
        $request->session()->regenerateToken();

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}