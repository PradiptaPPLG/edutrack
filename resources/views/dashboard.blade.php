@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
{{-- Cek session login_success dan hapus setelah digunakan --}}
@php
    $showLoginNotification = session('login_success', false);
    if ($showLoginNotification) {
        session()->forget('login_success');
    }
@endphp

<div x-data="{ 
        loading: true,
        showNotification: @json($showLoginNotification),
        showContent: false
    }" 
    x-init="
        setTimeout(() => { 
            loading = false; 
            showContent = true;
            
            // Auto-hide notifikasi setelah 3 detik jika muncul
            if (showNotification) {
                setTimeout(() => showNotification = false, 3000);
            }
            
            // Trigger animasi fade-in-up setelah konten tampil
            setTimeout(() => {
                document.querySelectorAll('.fade-in-up').forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('animated');
                    }, index * 150); // delay 150ms per elemen
                });
            }, 100);
        }, 2500)
    ">
    
    <!-- Loading Spinner di dalam dashboard -->
    <div x-show="loading" x-cloak 
         class="flex flex-col items-center justify-center py-64 bg-white rounded-2xl shadow-sm border">
        <div class="w-16 h-16 border-4 border-sky-200 border-t-sky-600 rounded-full animate-spin mb-4"></div>
        <p class="text-sky-600 font-semibold">Memuat dashboard...</p>
    </div>

    <!-- Notifikasi Tailwind (hanya muncul saat login berhasil) -->
    <div x-show="showNotification" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed top-20 right-4 z-[100] bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-lg">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-green-600 mr-2">check_circle</span>
            <span>Login berhasil! Selamat datang kembali.</span>
        </div>
    </div>

    <!-- Konten dashboard (ditampilkan setelah loading selesai) -->
    <div x-show="showContent" x-cloak>
        <style>
        .heatmap-grid {
            display: grid;
            grid-auto-flow: column;
            grid-template-rows: repeat(7, 12px);
            gap: 3px;
        }

        .heat-cell {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            background: #ebedf0;
        }

        .level-0 { background: #ebedf0; }
        .level-1 { background: #9be9a8; }
        .level-2 { background: #40c463; }
        .level-3 { background: #30a14e; }
        .level-4 { background: #216e39; }

        /* Animasi fade in up */
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

        /* Hover effect untuk cards */
        .summary-card {
            transition: all 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        </style>

        <!-- ================= HERO SECTION ================= -->
        <div class="bg-gradient-to-r from-sky-500 to-purple-600 rounded-2xl p-8 text-white mb-8 shadow-lg relative overflow-hidden fade-in-up">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-2">Selamat datang kembali, {{ Auth::user()->name }}!</h2>
                <p class="text-sky-100 text-lg max-w-xl">
                    {{ Auth::user()->quote ?? 'Terus belajar, terus berkembang, dan jadilah versi terbaik dirimu.' }}
                </p>

                <a href="{{ route('notes.create') }}"
                   class="inline-flex items-center gap-2 mt-6 bg-white text-sky-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-sky-50 transition-all hover:scale-105">
                    <span class="material-symbols-outlined">add_circle</span>
                    Buat Catatan Baru
                </a>
            </div>

            <div class="absolute right-0 top-0 h-64 w-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 animate-pulse"></div>
        </div>

        <!-- ================= SUMMARY CARDS ================= -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- AVG GRADE -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border flex items-center justify-between summary-card fade-in-up">
                <div>
                    <p class="text-sm text-gray-500">Rata-rata Nilai</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ number_format($avgGrade, 2) }}</h3>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                    <span class="material-symbols-outlined">grade</span>
                </div>
            </div>

            <!-- PENDING ASSIGNMENTS -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border flex items-center justify-between summary-card fade-in-up">
                <div>
                    <p class="text-sm text-gray-500">Tugas Belum Selesai</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $pendingAssignments }}</h3>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined">assignment_late</span>
                </div>
            </div>

            <!-- TODAY SCHEDULE -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border summary-card fade-in-up">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm text-gray-500">Jadwal Hari Ini</p>
                    <span class="material-symbols-outlined text-blue-600">calendar_today</span>
                </div>

                @if($todaysSchedule->count())
                    <div class="space-y-2 mt-2">
                        @foreach($todaysSchedule->take(3) as $schedule)
                            <div class="flex items-center gap-2 text-sm p-2 hover:bg-gray-50 rounded-lg transition-all">
                                <span class="font-medium text-sky-600">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                                <span class="text-gray-600">{{ $schedule->subject->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 mt-2 italic">Tidak ada kelas hari ini</p>
                @endif
            </div>
        </div>

        <!-- ================= AI STUDY COACH PLACEHOLDER ================= -->
        <div class="mb-10 fade-in-up">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🧠 AI Study Coach</h3>
            <div class="p-8 bg-white rounded-2xl shadow border border-dashed flex flex-col items-center text-center hover:border-sky-300 transition-all hover:shadow-md">
                <span class="material-symbols-outlined text-6xl text-sky-400 mb-2 animate-bounce">smart_toy</span>
                <p class="text-lg font-semibold">AI belum tersedia.</p>
                <p class="text-sm text-gray-500">Aktifkan OpenAI API untuk rekomendasi belajar personal.</p>
            </div>
        </div>

        <!-- ================= LEARNING ACTIVITY HEATMAP ================= -->
        <div class="mb-12 fade-in-up">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Learning Activity Heatmap</h3>
            <div class="bg-white p-4 rounded-xl shadow border overflow-x-auto hover:shadow-lg transition-all">
                <div class="heatmap-grid">
                    @php
                        $start = now()->subDays(30);
                    @endphp

                    @for($i = 0; $i < 365; $i++)
                        @php
                            $date = $start->copy()->addDays($i)->format('Y-m-d');
                            $score = $heatmap[$date] ?? null;

                            $level = 0;
                            if($score >= 85) $level = 4;
                            elseif($score >= 70) $level = 3;
                            elseif($score >= 60) $level = 2;
                            elseif($score !== null) $level = 1;
                        @endphp

                        <div class="heat-cell level-{{ $level }} transition-all hover:scale-150 hover:z-10" 
                             title="{{ $date }} | {{ $score ?: 'Tidak ada aktivitas' }}"></div>
                    @endfor
                </div>

                <!-- Legend -->
                <div class="flex items-center gap-2 mt-3 text-xs text-gray-500">
                    <span>Less</span>
                    <div class="heat-cell level-0"></div>
                    <div class="heat-cell level-1"></div>
                    <div class="heat-cell level-2"></div>
                    <div class="heat-cell level-3"></div>
                    <div class="heat-cell level-4"></div>
                    <span>More</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection