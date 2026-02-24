<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Services\StreakService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SocialiteController extends Controller
{
    /**
     * Redirect ke Google untuk login
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login Google gagal, silakan coba lagi.');
        }

        // Cek apakah user sudah ada berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // User belum ada, buat baru dengan streak 1
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(16)), // password random tidak dipakai
                'streak' => 1, // Set streak awal 1 untuk user baru
                'last_login_date' => Carbon::today(), // Set last login ke hari ini
            ]);

            // Download avatar dari Google dan simpan ke storage
            if ($googleUser->getAvatar()) {
                try {
                    $avatarUrl = $googleUser->getAvatar();
                    $contents = file_get_contents($avatarUrl);
                    $filename = 'profile-photos/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($filename, $contents);
                    $user->profile_photo_path = $filename;
                    $user->save();
                } catch (\Exception $e) {
                    // Abaikan jika gagal download avatar
                }
            }
        } else {
            // User sudah ada, update google_id jika belum ada
            if (is_null($user->google_id)) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
            
            // Update streak menggunakan StreakService
            StreakService::update($user);
        }

        // Login user
        Auth::login($user, true);

        return redirect()->intended('dashboard')->with('success', 'Login berhasil dengan Google!');
    }
}