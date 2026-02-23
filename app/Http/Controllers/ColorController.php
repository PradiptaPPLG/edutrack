<?php

namespace App\Http\Controllers;

use App\Models\SubjectColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'color_code' => 'required|string|max:7'
        ]);

        SubjectColor::create([
            'user_id' => auth()->id(),
            'color_code' => $request->color_code,
        ]);

        return back()->with('success', 'Warna baru ditambahkan');
    }
    public function ajaxStore(Request $r){
    $color = SubjectColor::create([
        'user_id' => auth()->id(),
        'color_code' => $r->color_code
    ]);

    return response()->json($color);
}
}