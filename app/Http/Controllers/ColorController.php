<?php

// File: app/Http/Controllers/ColorController.php
// Controller untuk mengelola warna-warna yang dapat digunakan oleh pengguna (untuk mata pelajaran)

namespace App\Http\Controllers;

use App\Models\SubjectColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Menyimpan warna baru ke database (melalui form biasa).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input: color_code wajib diisi, string, maksimal 7 karakter (format warna seperti #FFFFFF)
        $request->validate([
            'color_code' => 'required|string|max:7'
        ]);

        // Buat record warna baru untuk user yang sedang login
        SubjectColor::create([
            'user_id' => auth()->id(),
            'color_code' => $request->color_code,
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Warna baru ditambahkan');
    }

    /**
     * Menyimpan warna baru melalui AJAX (permintaan dari JavaScript).
     * Mengembalikan response JSON agar dapat diproses oleh frontend.
     *
     * @param  \Illuminate\Http\Request  $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxStore(Request $r)
    {
        // Buat record warna baru untuk user yang sedang login
        $color = SubjectColor::create([
            'user_id' => auth()->id(),
            'color_code' => $r->color_code
        ]);

        // Kembalikan data warna yang baru dibuat dalam format JSON
        // Frontend dapat menggunakan data ini untuk menambahkan warna ke dropdown tanpa reload halaman
        return response()->json($color);
    }
}