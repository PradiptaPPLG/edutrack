<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AccountController; 
use App\Http\Controllers\GameController;
use App\Http\Controllers\AchievementController; // TAMBAHKAN INI
use App\Http\Controllers\SocialiteController; // TAMBAHKAN INI

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

// ===== SEMUA ROUTE YANG BUTUH AUTH DI SATU GROUP =====
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Subjects
    Route::resource('subjects', SubjectController::class);
    Route::post('/subject-colors', [ColorController::class, 'store'])->name('colors.store');
    Route::post('/colors/ajax', [ColorController::class, 'ajaxStore']);
    
    // Assignments, Schedules, Grades, Attendances, Notes
    Route::resource('assignments', AssignmentController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('notes', NoteController::class);
    
    // Account (Profile & Settings)
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
    Route::put('/settings', [AccountController::class, 'updateSettings'])->name('settings.update');
    
    // Achievements
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements');
    
    // ===== GAMES ROUTES =====
    // Halaman Game Hub (daftar semua game) - HANYA SATU!
    Route::get('/games', function() {
        return view('games.index');
    })->name('games.index');
    
    // Halaman Wordle
    Route::get('/game/wordle', function() {
        return view('games.wordle');
    })->name('game.wordle');
    
    Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/api/game/xp', [GameController::class, 'awardXp'])->name('game.xp');
});
});

// Google Auth (boleh di luar karena sudah handle sendiri)
Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');