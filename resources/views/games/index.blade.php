@extends('layouts.app')

@section('header', ' Mini Games Hub')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <h2 class="text-3xl font-bold mb-2">Mini Games</h2>
        <p class="text-purple-100">Main game dan kumpulkan XP untuk naik level! 🚀</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Card Game Wordle --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="h-40 bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-white">abc</span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">Wordle</h3>
                <p class="text-gray-600 text-sm mb-4">Tebak kata 5 huruf dalam 6 kesempatan. Dapatkan XP berdasarkan jumlah tebakan!</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1 text-yellow-500">
                        <span class="material-symbols-outlined text-sm">star</span>
                        <span class="text-sm font-semibold">20-45 XP</span>
                    </div>
                    <a href="{{ route('game.wordle') }}" 
                       class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-sky-700 transition">
                        <span class="material-symbols-outlined text-sm">play_arrow</span>
                        Mainkan
                    </a>
                </div>
            </div>
        </div>

        {{-- Card Game Memory (Coming Soon) --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden opacity-75">
            <div class="h-40 bg-gradient-to-r from-gray-400 to-gray-500 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-white">memory</span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">Memory Card</h3>
                <p class="text-gray-600 text-sm mb-4">Latih daya ingat dengan mencocokkan kartu. Segera hadir!</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">Coming Soon</span>
                    <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                        Mainkan
                    </button>
                </div>
            </div>
        </div>

        {{-- Card Game Maze (Coming Soon) --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden opacity-75">
            <div class="h-40 bg-gradient-to-r from-gray-400 to-gray-500 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-white">explore</span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">Maze Runner</h3>
                <p class="text-gray-600 text-sm mb-4">Temukan jalan keluar dari labirin. Segera hadir!</p>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">Coming Soon</span>
                    <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                        Mainkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection