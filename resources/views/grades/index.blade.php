@extends('layouts.app')
@section('header','Nilai')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

/* Hover effect untuk kartu nilai */
.grade-card {
    transition: all 0.3s ease;
}
.grade-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Hover effect untuk kartu statistik */
.stat-card {
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
</style>

{{-- ===== NOTIFIKASI XP ===== --}}
@if(session('success'))
    @if(str_contains(session('success'), '+10 XP'))
        <div class="mb-4 p-4 bg-gradient-to-r from-yellow-400 to-amber-500 text-white rounded-lg shadow-lg flex items-center gap-3 animate-pulse fade-in-up">
            <span class="text-2xl">⭐</span>
            <div class="flex-1">
                <p class="font-bold">{{ session('success') }}</p>
                <p class="text-sm text-yellow-100">Total XP: {{ number_format(Auth::user()->xp) }} | Level {{ Auth::user()->level }}</p>
            </div>
            <span class="text-3xl">🏆</span>
        </div>
    @else
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg fade-in-up">
            {{ session('success') }}
        </div>
    @endif
@endif
{{-- ===== END NOTIFIKASI XP ===== --}}

{{-- Header dengan tombol tambah --}}
<div class="flex justify-between items-center mb-6 fade-in-up">
    <h2 class="text-xl font-bold">Daftar Nilai</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <span class="material-symbols-outlined">add</span> Tambah
    </button>
</div>

{{-- ===== BAGIAN CHART VISUALISASI ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <!-- LINE CHART: Progress nilai dari waktu ke waktu -->
    <div class="bg-white p-4 rounded-xl shadow fade-in-up">
        <h3 class="font-semibold mb-2">📈 Progress Nilai</h3>
        <canvas id="lineChart"></canvas>
    </div>

    <!-- BAR CHART: Rata-rata per mata pelajaran -->
    <div class="bg-white p-4 rounded-xl shadow fade-in-up">
        <h3 class="font-semibold mb-2">📊 Rata-rata per Mapel</h3>
        <canvas id="barChart"></canvas>
    </div>
</div>

{{-- ===== STATISTIK DENGAN KKM ===== --}}
@php
    $totalData = $grades->count();
    $rataRata = $grades->avg('score');
    $nilaiTertinggi = $grades->max('score');
    $nilaiTerendah = $grades->min('score');
    
    // Statistik berdasarkan KKM
    $kkm = Auth::user()->kkm ?? 75;
    $diAtasKKM = $grades->filter(function($g) use ($kkm) {
        return $g->score >= $kkm;
    })->count();
    
    $diBawahKKM = $grades->filter(function($g) use ($kkm) {
        return $g->score < $kkm;
    })->count();
    
    $persenTuntas = $totalData > 0 ? round(($diAtasKKM / $totalData) * 100, 1) : 0;
@endphp

{{-- Grid statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
    <!-- Total Nilai -->
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-blue-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Total Data Nilai</p>
        <p class="text-2xl font-bold">{{ $totalData }}</p>
    </div>
    
    <!-- Rata-rata -->
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-green-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Rata-rata Nilai</p>
        <p class="text-2xl font-bold">{{ number_format($rataRata, 2) }}</p>
    </div>
    
    <!-- Nilai Tertinggi -->
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-yellow-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Nilai Tertinggi</p>
        <p class="text-2xl font-bold">{{ $nilaiTertinggi ?? 0 }}</p>
    </div>
    
    <!-- Nilai Terendah -->
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-red-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Nilai Terendah</p>
        <p class="text-2xl font-bold">{{ $nilaiTerendah ?? 0 }}</p>
    </div>
    
    <!-- Di Atas KKM -->
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-emerald-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Di Atas KKM ({{ $kkm }})</p>
        <p class="text-2xl font-bold">{{ $diAtasKKM }}</p>
        <p class="text-xs text-gray-400">{{ $persenTuntas }}% tuntas</p>
    </div>
    
    <!-- Di Bawah KKM -->
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-orange-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Di Bawah KKM ({{ $kkm }})</p>
        <p class="text-2xl font-bold">{{ $diBawahKKM }}</p>
    </div>
</div>

{{-- ===== GRID CARD NILAI ===== --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
@foreach($grades as $g)
    @php
        $kkm = Auth::user()->kkm ?? 75;
        if ($g->score >= $kkm) {
            $color = '#22c55e';
        } elseif ($g->score >= $kkm - 15) {
            $color = '#f59e0b';
        } else {
            $color = '#ef4444';
        }
    @endphp
    <div class="bg-white rounded-xl shadow border p-4 relative border-l-8 grade-card fade-in-up" 
         style="border-left-color: {{ $color }}; border-left-width: 8px;">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-semibold text-lg">{{ $g->activity_name }}</h3>
                <p class="text-sm text-gray-500">{{ $g->subject->name }}</p>
                @if($g->score < $kkm)
                    <span class="text-xs text-red-500 mt-1 block">Di bawah KKM ({{ $kkm }})</span>
                @else
                    <span class="text-xs text-green-500 mt-1 block">Mencapai KKM ({{ $kkm }})</span>
                @endif
            </div>
            <div class="text-xl font-bold" style="color: {{ $color }}">
                {{ $g->score }}
            </div>
        </div>
        <div class="mt-4 flex justify-end gap-3 text-sm">
            <button onclick="openEditModal('{{ $g->id }}','{{ $g->activity_name }}','{{ $g->subject_id }}','{{ $g->score }}')"
                class="text-blue-600 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">edit</span> Edit
            </button>
            <form action="{{ route('grades.destroy',$g) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">delete</span> Hapus
                </button>
            </form>
        </div>
    </div>
@endforeach
</div>

{{-- MODAL TAMBAH NILAI --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeAddModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-lg">Tambah Nilai</h3>
            <button onclick="closeAddModal()" class="text-gray-400">✕</button>
        </div>
        <form action="{{ route('grades.store') }}" method="POST">
            @csrf
            <select name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
            <input name="activity_name" placeholder="Nama aktivitas (UTS, Quiz, dll)" class="w-full border rounded px-3 py-2 mb-3">
            <input type="number" name="score" min="0" max="100" step="0.01" placeholder="Nilai (0-100)" class="w-full border rounded px-3 py-2 mb-3">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT NILAI --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeEditModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-lg">Edit Nilai</h3>
            <button onclick="closeEditModal()" class="text-gray-400">✕</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <select id="editSubject" name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
            <input id="editActivity" name="activity_name" class="w-full border rounded px-3 py-2 mb-3">
            <input id="editScore" type="number" name="score" min="0" max="100" step="0.01" class="w-full border rounded px-3 py-2 mb-3">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT untuk chart, modal, dan animasi --}}
<script>
const addModal = document.getElementById('addModal');
const editModal = document.getElementById('editModal');
const editForm = document.getElementById('editForm');
const editActivity = document.getElementById('editActivity');
const editSubject = document.getElementById('editSubject');
const editScore = document.getElementById('editScore');

// Fungsi modal
function openAddModal(){ addModal.classList.remove('hidden') }
function closeAddModal(e){ if(!e || e.target.id==='addModal') addModal.classList.add('hidden') }

function openEditModal(id,name,subject,score){
    editModal.classList.remove('hidden');
    editForm.action="/grades/"+id;
    editActivity.value=name;
    editSubject.value=subject;
    editScore.value=score;
}
function closeEditModal(e){ if(!e || e.target.id==='editModal') editModal.classList.add('hidden') }

// Data dari controller
const lineLabels = @json($lineLabels);
const lineScores = @json($lineScores);
const barLabels = @json($barLabels);
const barScores = @json($barScores);

// LINE CHART
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: lineLabels,
        datasets: [{
            label: 'Nilai',
            data: lineScores,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.15)',
            tension: 0.4
        }]
    }
});

// BAR CHART
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: barLabels,
        datasets: [{
            label: 'Rata-rata Nilai',
            data: barScores,
            backgroundColor: '#22c55e'
        }]
    }
});

// Animasi fade-in-up setelah halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.classList.add('animated');
        }, index * 100); // delay 100ms per elemen
    });
});
</script>

@endsection