<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            // User belum ada, buat baru
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(16)), // password random tidak dipakai
            ]);

            // Download avatar dari Google dan simpan ke storage
            if ($googleUser->getAvatar()) {
                $avatarUrl = $googleUser->getAvatar();
                $contents = file_get_contents($avatarUrl);
                $filename = 'profile-photos/' . uniqid() . '.jpg';
                Storage::disk('public')->put($filename, $contents);
                $user->profile_photo_path = $filename;
                $user->save();
            }
        } else {
            // User sudah ada, update google_id jika belum ada
            if (is_null($user->google_id)) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }
        }

        // Login user
        Auth::login($user, true);

        return redirect()->intended('dashboard')->with('success', 'Login berhasil dengan Google!');
    }
}