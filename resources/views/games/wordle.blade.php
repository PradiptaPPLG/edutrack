@extends('layouts.app')

@section('header', '🎮 Wordle')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- PASTIKAN INI ADA --}}
    
    <iframe src="{{ asset('game-assets/wordle/index.html') }}" 
            class="w-full h-[600px] border-0 rounded-lg"
            allowfullscreen></iframe>
</div>
@endsection