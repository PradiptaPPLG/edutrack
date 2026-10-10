@extends('layouts.app')
@section('header','Tugas')

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

/* Hover effect untuk card statistik */
.stat-card {
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Hover effect untuk card tugas */
.task-card {
    transition: all 0.3s ease;
}
.task-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Animasi soft pulse untuk XP notification */
@keyframes softPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.9; }
}
.xp-notification {
    animation: softPulse 2s infinite;
}

/* Modal animation */
.modal-content {
    transition: all 0.3s ease;
}
</style>

{{-- ===== NOTIFIKASI XP ===== --}}
@if(session('success'))
    @if(str_contains(session('success'), '+8 XP'))
        <div class="mb-4 p-4 bg-gradient-to-r from-green-400 to-emerald-500 text-white rounded-lg shadow-lg flex items-center gap-3 xp-notification fade-in-up">
            <span class="text-2xl">🎉</span>
            <div class="flex-1">
                <p class="font-bold">{{ session('success') }}</p>
                <p class="text-sm text-green-100">Total XP: {{ number_format(Auth::user()->xp) }} | Level {{ Auth::user()->level }}</p>
            </div>
            <span class="text-3xl">⚡</span>
        </div>
    @elseif(str_contains(session('success'), 'Tugas ditambahkan'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg fade-in-up">
            {{ session('success') }}
        </div>
    @else
        <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded-lg fade-in-up">
            {{ session('success') }}
        </div>
    @endif
@endif
{{-- ===== END NOTIFIKASI XP ===== --}}

{{-- Header dengan tombol tambah --}}
<div class="flex justify-between items-center mb-6 fade-in-up">
    <h2 class="text-xl font-bold">Daftar Tugas</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-sky-700 transition-all hover:scale-105">
        <span class="material-symbols-outlined">add</span> Tambah
    </button>
</div>

{{-- ===== REKAP TUGAS ===== --}}
@php
    $totalTugas = $assignments->count();
    $completedTugas = $assignments->where('status', 'Completed')->count();
    $pendingTugas = $assignments->where('status', 'Pending')->count();
    $persenCompleted = $totalTugas > 0 ? round(($completedTugas / $totalTugas) * 100) : 0;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <!-- Card Total Tugas -->
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500 flex items-center justify-between stat-card fade-in-up">
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Tugas</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalTugas }}</h3>
        </div>
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
            <span class="material-symbols-outlined text-2xl">assignment</span>
        </div>
    </div>

    <!-- Card Tugas Completed -->
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500 flex items-center justify-between stat-card fade-in-up">
        <div>
            <p class="text-sm text-gray-500 font-medium">Selesai</p>
            <h3 class="text-3xl font-bold text-green-600">{{ $completedTugas }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ $persenCompleted }}% dari total</p>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
            <span class="material-symbols-outlined text-2xl">check_circle</span>
        </div>
    </div>

    <!-- Card Tugas Pending -->
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-orange-500 flex items-center justify-between stat-card fade-in-up">
        <div>
            <p class="text-sm text-gray-500 font-medium">Belum Selesai</p>
            <h3 class="text-3xl font-bold text-orange-600">{{ $pendingTugas }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ 100 - $persenCompleted }}% dari total</p>
        </div>
        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
            <span class="material-symbols-outlined text-2xl">pending</span>
        </div>
    </div>
</div>

{{-- GRID CARD TUGAS --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
@foreach($assignments as $index => $a)
@php
    // Menentukan warna border berdasarkan status
    if($a->status == 'Completed'){
        $color = '#22c55e'; // hijau untuk tugas yang sudah selesai
    } else {
        $color = '#f59e0b'; // orange untuk tugas pending
    }
@endphp

{{-- Card tugas dengan border kiri berwarna --}}
<div class="bg-white rounded-xl shadow border p-4 relative border-l-8 task-card fade-in-up"
     style="border-left-color: {{ $color }}; border-left-width: 8px; transition-delay: {{ $index * 0.1 }}s;">

    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-semibold text-lg">{{ $a->title }}</h3>
            <p class="text-sm text-gray-500">{{ $a->subject->name }}</p>
        </div>

        <!-- Dot status -->
        <div class="w-4 h-4 rounded-full" style="background: {{ $color }}"></div>
    </div>

    <p class="text-xs mt-2 flex items-center gap-1">
        <span class="material-symbols-outlined text-xs">event</span>
        Deadline: {{ $a->due_date->format('d M Y') }}
    </p>

    {{-- Badge status dengan warna sesuai --}}
    <span class="inline-block mt-2 px-2 py-1 text-xs rounded"
          style="background: {{ $color }}20; color: {{ $color }}">
        {{ $a->status }}
    </span>

    {{-- Tombol aksi --}}
    <div class="mt-4 flex justify-end gap-3 text-sm">
        <button onclick="openEditModal('{{ $a->id }}','{{ $a->title }}','{{ $a->subject_id }}','{{ $a->due_date->format('Y-m-d') }}','{{ $a->status }}')"
            class="text-blue-600 flex items-center gap-1 hover:text-blue-800 transition-colors">
            <span class="material-symbols-outlined text-sm">edit</span> Edit
        </button>

        {{-- Form hapus dengan method DELETE --}}
        <form action="{{ route('assignments.destroy',$a) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tugas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 flex items-center gap-1 hover:text-red-800 transition-colors">
                <span class="material-symbols-outlined text-sm">delete</span> Hapus
            </button>
        </form>
    </div>
</div>
@endforeach
</div>

{{-- ===== MODAL TAMBAH TUGAS ===== --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeAddModal(event)">
    <div class="bg-white rounded-xl p-6 w-96 transform transition-all scale-95 opacity-0 modal-content" onclick="event.stopPropagation()" id="addModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Tambah Tugas</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf

            <select name="subject_id" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <input name="title" placeholder="Judul tugas" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="date" name="due_date" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">

            <select name="status" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                <option>Pending</option>
                <option>Completed</option>
            </select>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border rounded hover:bg-gray-100 transition-colors">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded hover:bg-sky-700 transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL EDIT TUGAS ===== --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeEditModal(event)">
    <div class="bg-white rounded-xl p-6 w-96 transform transition-all scale-95 opacity-0 modal-content" onclick="event.stopPropagation()" id="editModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Edit Tugas</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <select id="editSubject" name="subject_id" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <input id="editTitle" name="title" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">
            <input id="editDate" type="date" name="due_date" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">

            <select id="editStatus" name="status" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                <option>Pending</option>
                <option>Completed</option>
            </select>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded hover:bg-gray-100 transition-colors">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded hover:bg-sky-700 transition-colors">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript untuk modal --}}
<script>
const addModal = document.getElementById('addModal');
const editModal = document.getElementById('editModal');
const editForm = document.getElementById('editForm');
const editTitle = document.getElementById('editTitle');
const editSubject = document.getElementById('editSubject');
const editDate = document.getElementById('editDate');
const editStatus = document.getElementById('editStatus');

function openAddModal(){ 
    addModal.classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('addModalContent').classList.remove('scale-95', 'opacity-0');
        document.getElementById('addModalContent').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeAddModal(e){ 
    if(!e || e.target.id === 'addModal') {
        document.getElementById('addModalContent').classList.remove('scale-100', 'opacity-100');
        document.getElementById('addModalContent').classList.add('scale-95', 'opacity-0');
        setTimeout(() => addModal.classList.add('hidden'), 200);
    }
}

function openEditModal(id,title,subject,date,status){
    editModal.classList.remove('hidden');
    editForm.action="/assignments/"+id;
    editTitle.value=title;
    editSubject.value=subject;
    editDate.value=date;
    editStatus.value=status;
    
    setTimeout(() => {
        document.getElementById('editModalContent').classList.remove('scale-95', 'opacity-0');
        document.getElementById('editModalContent').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeEditModal(e){ 
    if(!e || e.target.id === 'editModal') {
        document.getElementById('editModalContent').classList.remove('scale-100', 'opacity-100');
        document.getElementById('editModalContent').classList.add('scale-95', 'opacity-0');
        setTimeout(() => editModal.classList.add('hidden'), 200);
    }
}

// Animasi fade-in-up setelah halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.classList.add('animated');
        }, index * 100);
    });
});
</script>

@endsection