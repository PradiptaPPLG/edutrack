@extends('layouts.app')
@section('header','Jadwal')

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

/* Hover effect untuk card hari */
.day-card {
    transition: all 0.3s ease;
}
.day-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Hover effect untuk item jadwal */
.schedule-item {
    transition: all 0.2s ease;
}
.schedule-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Animasi untuk modal */
.modal-content {
    transition: all 0.3s ease;
}
</style>

{{-- Header dengan tombol tambah --}}
<div class="flex justify-between items-center mb-6 fade-in-up">
    <h2 class="text-xl font-bold">Jadwal Pelajaran</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-sky-700 transition-all hover:scale-105">
        <span class="material-symbols-outlined">add</span> Tambah
    </button>
</div>

@php
// Daftar hari dalam seminggu (Senin-Sabtu)
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
$dayLabel = [
 'Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu',
 'Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'
];

// Warna untuk setiap hari (untuk border card)
$dayColors = [
 'Monday' => '#ef4444',   // merah
 'Tuesday' => '#f97316',  // oranye
 'Wednesday' => '#eab308',// kuning
 'Thursday' => '#22c55e', // hijau
 'Friday' => '#3b82f6',   // biru
 'Saturday' => '#8b5cf6', // ungu
];
@endphp

{{-- Grid 6 kolom untuk setiap hari (Senin-Sabtu) --}}
<div class="grid grid-cols-1 md:grid-cols-6 gap-4">
@foreach($days as $index => $d)
<div class="bg-white rounded-xl border shadow p-3 day-card fade-in-up" 
     style="transition-delay: {{ $index * 0.1 }}s;">
    <h3 class="font-semibold text-sm mb-2 pb-1 border-b" style="color: {{ $dayColors[$d] }}">{{ $dayLabel[$d] }}</h3>

    {{-- Tampilkan jadwal untuk hari ini --}}
    @forelse(($schedules[$d] ?? []) as $sc)
        @php $color = $dayColors[$d]; @endphp
        <div class="mb-2 p-2 rounded-lg border-l-4 text-sm bg-gray-50 schedule-item"
        style="border-left-color: {{ $color }}; border-left-width: 4px;">
            <div class="font-semibold">{{ $sc->subject->name }}</div>
            <div class="text-xs text-gray-500 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">schedule</span>
                {{ \Carbon\Carbon::parse($sc->start_time)->format('H:i') }} - 
                {{ \Carbon\Carbon::parse($sc->end_time)->format('H:i') }}
            </div>

            <div class="flex gap-3 text-xs mt-2 justify-end">
                <button onclick="openEditModal('{{ $sc->id }}','{{ $sc->subject_id }}','{{ $sc->day }}','{{ $sc->start_time }}','{{ $sc->end_time }}')" 
                    class="text-blue-600 hover:text-blue-800 flex items-center gap-0.5">
                    <span class="material-symbols-outlined text-xs">edit</span> Edit
                </button>

                <form method="POST" action="{{ route('schedules.destroy',$sc) }}" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-0.5">
                        <span class="material-symbols-outlined text-xs">delete</span> Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-xs text-gray-400 italic text-center py-3">Tidak ada jadwal</p>
    @endforelse
</div>
@endforeach
</div>

{{-- MODAL TAMBAH JADWAL --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeAddModal(event)">
    <div class="bg-white rounded-xl p-6 w-96 transform transition-all scale-95 opacity-0 modal-content" onclick="event.stopPropagation()" id="addModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Tambah Jadwal</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('schedules.store') }}">
            @csrf

            <select name="subject_id" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <select name="day" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">
                @foreach($days as $d)
                <option value="{{ $d }}">{{ $dayLabel[$d] }}</option>
                @endforeach
            </select>

            <div class="flex gap-2 mb-3">
                <input type="time" name="start_time" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                <input type="time" name="end_time" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border rounded hover:bg-gray-100 transition-colors">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded hover:bg-sky-700 transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT JADWAL --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeEditModal(event)">
    <div class="bg-white rounded-xl p-6 w-96 transform transition-all scale-95 opacity-0 modal-content" onclick="event.stopPropagation()" id="editModalContent">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Edit Jadwal</h3>
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

            <select id="editDay" name="day" class="w-full border rounded px-3 py-2 mb-3 focus:ring-2 focus:ring-primary focus:border-primary">
                @foreach($days as $d)
                <option value="{{ $d }}">{{ $dayLabel[$d] }}</option>
                @endforeach
            </select>

            <div class="flex gap-2 mb-3">
                <input id="editStart" type="time" name="start_time" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
                <input id="editEnd" type="time" name="end_time" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded hover:bg-gray-100 transition-colors">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded hover:bg-sky-700 transition-colors">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
const addModal = document.getElementById('addModal');
const editModal = document.getElementById('editModal');
const editForm = document.getElementById('editForm');
const editSubject = document.getElementById('editSubject');
const editDay = document.getElementById('editDay');
const editStart = document.getElementById('editStart');
const editEnd = document.getElementById('editEnd');

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

function openEditModal(id,subject,day,start,end){
    editModal.classList.remove('hidden');
    editForm.action="/schedules/"+id;
    editSubject.value=subject;
    editDay.value=day;
    editStart.value=start;
    editEnd.value=end;
    
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