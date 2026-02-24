@extends('layouts.app')

@section('header', '🏆 Achievements & Tingkatan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- User Summary Card -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white mb-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                <p class="text-purple-100">{{ $user->email }}</p>
            </div>
            <div class="text-right">
                <div class="text-4xl font-bold">{{ $stats['level'] }}</div>
                <div class="text-purple-100">Level Saat Ini</div>
            </div>
        </div>
        
        <!-- Current Tier -->
        <div class="mt-4 bg-white/20 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <span class="text-3xl">🎯</span>
                <div>
                    <div class="font-semibold text-lg">{{ $currentTier['name'] }}</div>
                    <div class="text-sm text-purple-100 italic">"{{ $currentTier['philosophy'] }}"</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="text-3xl mb-2">📊</div>
            <div class="text-2xl font-bold">{{ number_format($stats['xp']) }}</div>
            <div class="text-sm text-gray-500">Total XP</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <div class="text-3xl mb-2">📝</div>
            <div class="text-2xl font-bold">{{ $stats['total_notes'] }}</div>
            <div class="text-sm text-gray-500">Catatan</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <div class="text-3xl mb-2">✅</div>
            <div class="text-2xl font-bold">{{ $stats['completed_tasks'] }}</div>
            <div class="text-sm text-gray-500">Tugas Selesai</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <div class="text-3xl mb-2">⭐</div>
            <div class="text-2xl font-bold">{{ $stats['high_scores'] }}</div>
            <div class="text-sm text-gray-500">Nilai Tinggi</div>
        </div>
    </div>
    
    <!-- Progress to Next Level -->
    @if($nextTier)
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="font-semibold text-lg mb-4">Progress ke Level {{ $user->level + 1 }}</h3>
        
        <!-- XP Progress -->
        <div class="mb-2">
            <div class="flex justify-between text-sm mb-1">
                <span>Experience Points (XP)</span>
                <span>{{ number_format($user->xp) }} / {{ number_format($nextTier['xp']) }}</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $progress }}%"></div>
            </div>
        </div>
        
        <p class="text-xs text-gray-500 mt-3">
            Dibutuhkan {{ max(0, $nextTier['xp'] - $user->xp) }} XP lagi untuk naik level.
        </p>
    </div>
    @endif
    
    <!-- All Tiers -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold text-lg mb-4">📜 Semua Tingkatan (1-16)</h3>
        
        <div class="space-y-3">
            @foreach($tiers as $level => $tier)
                @php
                    $isUnlocked = $tier['is_unlocked'];
                    $isCurrent = $user->level == $level;
                @endphp
                
                <div class="border rounded-lg p-4 transition-all duration-300 
                    {{ $isCurrent ? 'border-purple-400 bg-purple-50 ring-2 ring-purple-200' : '' }}
                    {{ $isUnlocked && !$isCurrent ? 'border-green-200 bg-green-50' : '' }}
                    {{ !$isUnlocked ? 'border-gray-200 bg-gray-50 opacity-75' : '' }}">
                    
                    <div class="flex items-center gap-3">
                        <!-- Level Circle dengan MEDALI (BUKAN ANGKA) -->
                        <div class="w-14 h-14 rounded-full flex items-center justify-center
                            {{ $isUnlocked ? 'bg-transparent' : 'bg-gray-300' }}">
                            
                            @if($isUnlocked)
                                {{-- Tampilkan gambar medali sesuai level --}}
                                <img src="{{ asset('images/medals/level' . $level . '.png') }}" 
                                     alt="Level {{ $level }}" 
                                     class="w-14 h-14 object-contain"
                                     onerror="this.onerror=null; this.src='{{ asset('images/medals/level1.png') }}';">
                            @else
                                {{-- Tampilkan icon kunci --}}
                                <span class="text-white text-2xl">🔒</span>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <!-- Nama Tingkatan -->
                                <h4 class="font-semibold {{ $isUnlocked ? 'text-gray-800' : 'text-gray-500' }}">
                                    {{ $tier['name'] }}
                                </h4>
                                
                                <!-- Badge Status -->
                                @if($isCurrent)
                                    <span class="bg-purple-200 text-purple-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                        Saat Ini
                                    </span>
                                @elseif($isUnlocked)
                                    <span class="bg-green-200 text-green-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                        ✓ Terbuka
                                    </span>
                                @else
                                    <span class="bg-gray-200 text-gray-600 text-xs px-2 py-0.5 rounded-full font-medium flex items-center gap-1">
                                        <span>🔒</span> Terkunci
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Filosofi / Deskripsi -->
                            <p class="text-sm {{ $isUnlocked ? 'text-gray-600' : 'text-gray-400' }} italic">
                                @if($isUnlocked)
                                    "{{ $tier['philosophy'] }}"
                                @else
                                    "??? - Terus belajar untuk membuka tingkatan ini"
                                @endif
                            </p>
                            
                            <!-- Requirements (HANYA XP, TIDAK PAKAI NOTES) -->
                            <div class="flex gap-4 mt-2">
                                <div class="flex items-center gap-1 text-xs {{ $isUnlocked ? 'text-gray-500' : 'text-gray-400' }}">
                                    <span>🎯</span>
                                    @if($isUnlocked)
                                        <span>{{ number_format($tier['xp']) }} XP</span>
                                    @else
                                        <span>??? XP</span>
                                    @endif
                                </div>
                                {{-- NOTES REQUIREMENT DIHAPUS --}}
                            </div>
                            
                            <!-- Hidden hint untuk yang terkunci -->
@if(!$isUnlocked && $level > 1)
    <div class="mt-1 text-xs text-gray-400 flex items-center gap-1">
        <span class="material-symbols-outlined text-xs">lock</span>
        <span>
            @if(is_numeric($tier['xp']))
                Capai {{ number_format($tier['xp']) }} XP untuk membuka
            @else
                Capai level {{ $level }} untuk membuka
            @endif
        </span>
    </div>
@endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection