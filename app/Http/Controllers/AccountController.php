<?php

// File: app/Http/Controllers/AccountController.php
// Controller untuk mengelola akun pengguna (profil dan pengaturan)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AccountController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();
        // Tampilkan view profile dengan data user
        return view('account.profile', compact('user'));
    }

    /**
     * Memproses pembaruan data profil (nama, email, password, foto).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // unique kecuali user ini sendiri
            'password' => 'nullable|min:8|confirmed', // password boleh kosong, jika diisi minimal 8 dan harus cocok dengan konfirmasi
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // foto opsional, format tertentu, maks 2MB
        ]);

        // Update name dan email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password jika diisi (tidak kosong)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto jika ada file yang diunggah
        if ($request->hasFile('profile_photo')) {
            try {
                // Hapus foto lama jika ada
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Simpan foto baru ke folder 'profile-photos' di disk public
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->profile_photo_path = $path;
                
                // Catat log untuk debugging
                \Log::info('Foto disimpan di: ' . $path);
                
            } catch (\Exception $e) {
                // Jika terjadi error saat upload, kembalikan ke halaman sebelumnya dengan pesan error
                return redirect()->back()->with('error', 'Gagal upload: ' . $e->getMessage())->withInput();
            }
        }

        // Simpan semua perubahan ke database
        $user->save();

        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menampilkan halaman pengaturan (settings) pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        // Tampilkan view settings dengan data user
        return view('account.settings', compact('user'));
    }

    /**
     * Memproses pembaruan pengaturan (KKM, quote, dark mode).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'kkm' => 'required|integer|min:0|max:100', // KKM harus angka 0-100
            'quote' => 'nullable|string|max:255', // quote opsional, maks 255 karakter
        ]);

        // Update field-field pengaturan
        $user->kkm = $request->kkm;
        $user->quote = $request->quote;
        // dark_mode: jika checkbox tercentang, $request->has('dark_mode') bernilai true, else false
        $user->dark_mode = $request->has('dark_mode');
        // Simpan perubahan
        $user->save();

        // Redirect ke halaman settings dengan pesan sukses
        return redirect()->route('settings')->with('success', 'Pengaturan berhasil disimpan.');
    }
}