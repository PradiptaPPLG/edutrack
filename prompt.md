PROMPT 1
ngga bukan gitu, aku cuma nyelipin readme.md bawaan aja ya
ulang ulnag deh
udah keliatan ya strukturnya "apa yang harus diubah?"
host bilang: "itu kan menu menunya belum bisa jalan tuh, nah itu yang di kerjain tuh bikin menu menu itu"
faham? 
kita harus membuat fitur fitur atau menu menu itu berjalan, disamping itu juga kita akan memperbaiki layoutnya supaya rapih bagus dan professional, sebelum ke pengerjaan ada beberapa aturan yang tidak bisa dibantah
1. jangan mengubah apapun yang diluar perintah (kecuali disuruh)
2. ingat selalu nama file, nama query, isi database dan yang paling penting koneksi antar web.php ke controllers atau ke folder penting lainnya
3. setelah generate code, cek lagi apakah sesuai yang dibutuhkan dan pastikan tidak ada error
4. setiap program code/function/class memiliki komentar untuk keterangan
5. jika mengalami error, pikirkan 1 solusi terbaik(recomended) tanpa "atau"

kita mulai dari yang paling penting (jantungnya)
routes\web.php
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
resources
resources\css
resources\js
resources\views
resources\views\auth
resources\views\auth\login.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - EduTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-sky-600">school</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h1>
            <p class="text-gray-500 text-sm">Masuk untuk melanjutkan perjalanan belajar Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="siswa@contoh.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors">
                Masuk
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-sky-600 hover:text-sky-500">Daftar di sini</a>
        </div>
    </div>
</body>
</html>

resources\views\auth\register.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - EduTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-sky-600">school</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Akun</h1>
            <p class="text-gray-500 text-sm">Bergabung dengan EduTrack untuk mengelola pembelajaran Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="Budi Santoso">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="siswa@contoh.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors">
                Daftar
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-sky-600 hover:text-sky-500">Masuk di sini</a>
        </div>
    </div>
</body>
</html>

resources\views\layouts
resources\views\layouts\app.blade.php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EduTrack') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0284c7', // Sky 600
                        secondary: '#10B981', // Emerald 500
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <span class="text-xl font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">school</span>
                    EduTrack
                </span>
            </div>

            <nav class="p-4 space-y-6 overflow-y-auto">
                <!-- Dashboard -->
                <div>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </div>

                <!-- Akademik -->
                <div>
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Akademik</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('subjects.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">book_2</span>
                            Mata Pelajaran
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('schedules.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">calendar_month</span>
                            Jadwal
                        </a>
                    </div>
                </div>

                <!-- Study Hub -->
                <div>
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pusat Belajar</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('notes.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">edit_note</span>
                            Catatan Saya
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('assignments.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">assignment</span>
                            Tugas
                        </a>
                    </div>
                </div>

                <!-- Performa -->
                <div>
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Performa</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('grades.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">grade</span>
                            Nilai
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('attendances.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">verified_user</span>
                            Kehadiran
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 mt-auto border-t border-gray-200 absolute bottom-0 w-64">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full text-left text-gray-600 hover:text-red-600 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <h1 class="text-lg font-semibold text-gray-800">
                    @yield('header', 'Dashboard')
                </h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">Selamat datang, <strong>{{ Auth::user()->name }}</strong></span>
                    <div class="w-8 h-8 bg-sky-100 rounded-full flex items-center justify-center text-primary font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-8">
                <!-- Flash Message removed (handled by SweetAlert2) -->

                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Delete Confirmation
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-btn') || e.target.closest('form[method="POST"] button[type="submit"]')) {
                const button = e.target.closest('button');
                const form = button.closest('form');

                if (form && form.querySelector('input[name="_method"][value="DELETE"]')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            }
        });

        // Incoming Feature Menu Toast
        document.querySelectorAll('a[href="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                Toast.fire({
                    icon: 'info',
                    title: 'Fitur belum tersedia'
                });
            });
        });
    </script>
</body>
</html>

resources\views\dashboard.blade.php
@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-sky-500 to-purple-600 rounded-2xl p-8 text-white mb-8 shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">Selamat datang kembali, {{ Auth::user()->name }}!</h2>
            <p class="text-sky-100 text-lg max-w-xl">
                Hanya mereka yang terus melangkah maju yang akan mencapai garis finish. Teruslah belajar dan berkembang!
            </p>
            <a href="#" class="inline-flex items-center gap-2 mt-6 bg-white text-sky-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-sky-50 transition-colors">
                <span class="material-symbols-outlined">add_circle</span>
                Buat Catatan Baru
            </a>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute right-0 top-0 h-64 w-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Avg Grade -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Rata-rata Nilai</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($avgGrade, 2) }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <span class="material-symbols-outlined">grade</span>
            </div>
        </div>

        <!-- Pending Assignments -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Tugas Belum Selesai</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $pendingAssignments }}</h3>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                <span class="material-symbols-outlined">assignment_late</span>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-gray-500">Jadwal Hari Ini</p>
                <span class="material-symbols-outlined text-blue-600">calendar_today</span>
            </div>
            @if($todaysSchedule->count() > 0)
                <div class="space-y-2 mt-2">
                    @foreach($todaysSchedule->take(2) as $schedule)
                        <div class="flex items-center gap-2 text-sm">
                            <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                            <span class="text-gray-600 truncate">{{ $schedule->subject->name }}</span>
                        </div>
                    @endforeach
                    @if($todaysSchedule->count() > 2)
                        <p class="text-xs text-gray-400">+{{ $todaysSchedule->count() - 2 }} lainnya</p>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-400 mt-2">Tidak ada kelas hari ini</p>
            @endif
        </div>
    </div>

    <!-- AI Widget Area -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Asisten Belajar AI</h3>
        <div id="ai-widget" class="mt-8 p-10 bg-white rounded-3xl shadow-sm border-2 border-dashed border-gray-200 h-64 flex items-center justify-center text-gray-400">
            <div class="text-center">
                <span class="material-symbols-outlined text-5xl mb-3 text-sky-300">smart_toy</span>
                <p class="text-lg">Memuat Widget AI...</p>
                <p class="text-sm text-gray-400 mt-1">Siap untuk integrasi fitur AI</p>
            </div>
        </div>
    </div>
@endsection

resources\views\welcome.blade.php <- kayaknya ini bawaan deh, minta aja kalo perlu
app\Http\Controllers\AuthController.php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Menangani proses registrasi pengguna baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang di EduTrack.');
    }

    /**
     * Menangani proses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}

app\Http\Controllers\DashboardController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dasbor aplikasi.
     */
    public function index()
    {
        $user = Auth::user();

        // Data Ringkasan
        $avgGrade = $user->grades()->avg('score') ?? 0;
        $pendingAssignments = $user->assignments()->where('status', 'Pending')->count();

        $today = Carbon::now()->format('l'); // contoh: Monday
        $todaysSchedule = $user->schedules()->where('day', $today)->orderBy('start_time')->with('subject')->get();

        return view('dashboard', compact('avgGrade', 'pendingAssignments', 'todaysSchedule'));
    }
}
app\Models\User.php
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the notes for the user.
     */
    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function subjects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function assignments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function schedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function grades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
database\migrations\0001_01_01_000000_create_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
database\seeders\DatabaseSeeder.php
<?php

namespace Database\Seeders;

use App\Models\{
    Assignment,
    Grade,
    Note,
    Schedule,
    Subject,
    User,
    Attendance
};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Siswa EduTrack',
            'email' => 'siswa@edutrack.com',
            'password' => bcrypt('password'),
        ]);

        // $subjects = Subject::factory(6)->create([
        //     'user_id' => $user->id,
        // ]);

        // foreach ($subjects as $subject) {
        //     Assignment::factory(3)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);

        //     Schedule::factory(2)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);

        //     Grade::factory(4)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);

        //     Attendance::factory(5)->create([
        //         'user_id' => $user->id,
        //         'subject_id' => $subject->id,
        //     ]);
        // }

        // Note::factory(5)->create([
        //     'user_id' => $user->id,
        //     'subject_id' => $subjects->random()->id,
        // ]);

        // Note::factory(3)->create([
        //     'user_id' => $user->id,
        //     'subject_id' => null,
        //     'category' => 'General',
        // ]);
    }
}
aku hanya menyalin sebagian kecil file nya, struktur foldernya dah aku kasih kan? minta kalo butuh ya nanti aku langsung tampilin isi code nya
TAHAP 1: perbaiki login
apa yang harus diperbaiki? lihat saja di code, yang aku ketahui itu layoutnya belum menarik, dan route atau logikanya belum aku cek secara keseluruham, perhatikan aja

TAPI!, sebelum itu aku belum menemukan vendor, berarti belum composer instal, database nya juga belum ada, jadi kita harus bikin database nya dulu, buat database nya sesuai dengan ketersedaiaan atau sesuai ketentuan yang aku kirim, misalnya ada file assignment nih, kamu jangan dulu bikin tabel itu soalnya kamu belum mengetahui struktur code nya, mungkin yang ditampilkan tadi users kan, nah berarti bikinin database users dulu aja/yang baru dikaish kode nya, setiap aku ngasih code file baru, kamu harus ngeh dan tambahin ke database
ini ada readme.md bawaan untuk informasi atau langkah lebih detail dan jelasnya, isinya: 

# EduTrack - Student Activity Management Platform

EduTrack is a starter project built with Laravel 11, designed to help students manage their learning activities and notes. It features a clean, MVC-structured codebase with a minimal and professional UI using Tailwind CSS.

## Features

### Core Modules
- **Authentication**: Secure login and registration.
- Composer
- MySQL

## Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/username/edutrack.git
    cd edutrack
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan (.env)**
    Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi database:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan atur:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=edutrack
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Key Aplikasi**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi dan Seeding Database**
    Jalankan perintah ini untuk membuat tabel dan mengisi data awal (termasuk akun Siswa):
    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Server Lokal**
    ```bash
    npm run build
    php artisan serve
    ```
    Akses aplikasi di `http://localhost:8000`.

## Akses Login Default (VERY IMPORTANT) 

Setelah menjalankan seeding, Anda dapat masuk menggunakan akun berikut:

-   **Email**: `siswa@edutrack.com`
-   **Password**: `password`

## Struktur Data

- **Models**:
  - `App\Models\User`
  - `App\Models\Note`
  - `App\Models\Subject`
  - `App\Models\Assignment`
  - `App\Models\Schedule`
  - `App\Models\Grade`
  - `App\Models\Attendance`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
okeh, jelas? mulai dari instal vendor > bikin database > set env > perbaiki login


