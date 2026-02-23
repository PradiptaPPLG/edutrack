<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AccountController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update name dan email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto
        if ($request->hasFile('profile_photo')) {
            try {
                // Hapus foto lama
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Simpan foto baru
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->profile_photo_path = $path;
                
                \Log::info('Foto disimpan di: ' . $path);
                
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal upload: ' . $e->getMessage())->withInput();
            }
        }

        // Simpan semua perubahan sekaligus
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function settings()
    {
        $user = Auth::user();
        return view('account.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'kkm' => 'required|integer|min:0|max:100',
            'quote' => 'nullable|string|max:255',
        ]);

        $user->kkm = $request->kkm;
        $user->quote = $request->quote;
        $user->dark_mode = $request->has('dark_mode');
        $user->save();

        return redirect()->route('settings')->with('success', 'Pengaturan berhasil disimpan.');
    }
}