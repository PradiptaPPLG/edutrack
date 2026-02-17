@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-sky-500 to-purple-600 rounded-2xl p-8 text-white mb-8 shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">Selamat datang kembali, {{ Auth::user()->name }}!</h2>
            <p class="text-sky-100 text-lg max-w-xl">
                Hanya mereka yang terus melangkah maju yang akan mencapai garis finish. Teruslah belajar dan berkembang!
            </p>
            <a href="{{ route('notes.create') }}" class="inline-flex items-center gap-2 mt-6 bg-white text-sky-600 px-5 py-2.5 rounded-lg font-semibold hover:bg-sky-50 transition-colors">
                <span class="material-symbols-outlined">add_circle</span>
                Buat Catatan Baru
            </a>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute right-0 top-0 h-64 w-64 bg-white opacity-10 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Avg Grade -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Rata-rata Nilai</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($avgGrade, 2) }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <span class="material-symbols-outlined">grade</span>
            </div>
        </div>

        <!-- Pending Assignments -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Tugas Belum Selesai</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $pendingAssignments }}</h3>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                <span class="material-symbols-outlined">assignment_late</span>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-gray-500">Jadwal Hari Ini</p>
                <span class="material-symbols-outlined text-blue-600">calendar_today</span>
            </div>
            @if($todaysSchedule->count() > 0)
                <div class="space-y-2 mt-2">
                    @foreach($todaysSchedule->take(2) as $schedule)
                        <div class="flex items-center gap-2 text-sm">
                            <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                            <span class="text-gray-600 truncate">{{ $schedule->subject->name }}</span>
                        </div>
                    @endforeach
                    @if($todaysSchedule->count() > 2)
                        <p class="text-xs text-gray-400">+{{ $todaysSchedule->count() - 2 }} lainnya</p>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-400 mt-2">Tidak ada kelas hari ini</p>
            @endif
        </div>
    </div>

    <!-- AI Widget Area -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Asisten Belajar AI</h3>
        <div id="ai-widget" class="mt-8 p-10 bg-white rounded-3xl shadow-sm border-2 border-dashed border-gray-200 h-64 flex items-center justify-center text-gray-400">
            <div class="text-center">
                <span class="material-symbols-outlined text-5xl mb-3 text-sky-300">smart_toy</span>
                <p class="text-lg">Memuat Widget AI...</p>
                <p class="text-sm text-gray-400 mt-1">Siap untuk integrasi fitur AI</p>
            </div>
        </div>
    </div>
@endsection
