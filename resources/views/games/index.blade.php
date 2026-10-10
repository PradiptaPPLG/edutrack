@extends('layouts.app')

@section('header', 'Mini Games Hub')

@section('content')

<style>
/* Animasi fade in up - sama seperti di dashboard */
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.3, 1), 
                transform 0.8s cubic-bezier(0.2, 0.9, 0.3, 1);
}

.fade-in-up.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Hover effect untuk card game */
.game-card {
    transition: all 0.3s ease;
}
.game-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Card coming soon - abu-abu semua */
.coming-soon-card {
    filter: grayscale(100%);
    opacity: 0.75;
    transition: all 0.3s ease;
}
.coming-soon-card:hover {
    filter: grayscale(80%);
    opacity: 0.85;
    transform: translateY(-3px);
}

/* Animasi untuk badge coming soon */
.coming-soon-badge {
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.05em;
}
</style>

<div class="max-w-6xl mx-auto">
    {{-- Hero Section dengan animasi --}}
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-8 text-white mb-8 shadow-lg fade-in-up">
        <h2 class="text-3xl font-bold mb-2">Mini Games</h2>
        <p class="text-purple-100">Main game seru dan asah kemampuanmu! 🎮</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Card Game Wordle (Tersedia) --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden game-card fade-in-up">
            <div class="h-40 bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-white">abc</span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">Wordle</h3>
                <p class="text-gray-600 text-sm mb-4">Tebak kata 5 huruf dalam 6 kesempatan. Uji kosakata dan kemampuan menebakmu!</p>
                <div class="flex items-center justify-end">
                    <a href="{{ route('game.wordle') }}" 
                       class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-sky-700 transition-all hover:scale-105">
                        <span class="material-symbols-outlined text-sm">play_arrow</span>
                        Mainkan
                    </a>
                </div>
            </div>
        </div>

        {{-- Card Game Memory (Coming Soon) - ABU-ABU --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden coming-soon-card fade-in-up">
            <div class="h-40 bg-gradient-to-r from-gray-400 to-gray-500 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-white">memory</span>
                <div class="absolute mt-20 coming-soon-badge">COMING SOON</div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 text-gray-600">Memory Card</h3>
                <p class="text-gray-500 text-sm mb-4">Latih daya ingat dengan mencocokkan kartu. Segera hadir!</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1 text-gray-400">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        <span class="text-sm">Segera</span>
                    </div>
                    <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                        Mainkan
                    </button>
                </div>
            </div>
        </div>

        {{-- Card Game Maze (Coming Soon) - ABU-ABU --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden coming-soon-card fade-in-up">
            <div class="h-40 bg-gradient-to-r from-gray-400 to-gray-500 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-white">explore</span>
                <div class="absolute mt-20 coming-soon-badge">COMING SOON</div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 text-gray-600">Maze Runner</h3>
                <p class="text-gray-500 text-sm mb-4">Temukan jalan keluar dari labirin. Segera hadir!</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1 text-gray-400">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        <span class="text-sm">Segera</span>
                    </div>
                    <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                        Mainkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Animasi fade-in-up setelah halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.classList.add('animated');
        }, index * 150); // delay 150ms per elemen
    });
});
</script>

@endsection