@extends('layouts.app')
@section('header','Jadwal')

@section('content')

{{-- Header dengan tombol tambah --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Jadwal Pelajaran</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2">
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

{{-- Grid 7 kolom untuk setiap hari --}}
<div class="grid grid-cols-1 md:grid-cols-7 gap-4">
@foreach($days as $d)
<div class="bg-white rounded-xl border shadow p-3">
    <h3 class="font-semibold text-sm mb-2">{{ $dayLabel[$d] }}</h3>

    {{-- Tampilkan jadwal untuk hari ini --}}
    @foreach(($schedules[$d] ?? []) as $sc)
        @php $color = $dayColors[$d]; @endphp
        <div class="mb-2 p-2 rounded-lg border-l-4 text-sm bg-gray-50"
        style="border-left-color: {{ $color }}; border-left-width: 4px;">
            <div class="font-semibold">{{ $sc->subject->name }}</div>
            <div class="text-xs text-gray-500">
                {{ $sc->start_time }} - {{ $sc->end_time }}
            </div>

            <div class="flex gap-2 text-xs mt-2">
                <button onclick="openEditModal('{{ $sc->id }}','{{ $sc->subject_id }}','{{ $sc->day }}','{{ $sc->start_time }}','{{ $sc->end_time }}')" class="text-blue-600">Edit</button>

                <form method="POST" action="{{ route('schedules.destroy',$sc) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600">Hapus</button>
                </form>
            </div>
        </div>
    @endforeach

</div>
@endforeach
</div>

{{-- MODAL TAMBAH JADWAL --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeAddModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <h3 class="font-semibold text-lg mb-4">Tambah Jadwal</h3>

        <form method="POST" action="{{ route('schedules.store') }}">
            @csrf

            <select name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <select name="day" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($days as $d)
                <option value="{{ $d }}">{{ $dayLabel[$d] }}</option>
                @endforeach
            </select>

            <div class="flex gap-2 mb-3">
                <input type="time" name="start_time" class="w-full border rounded px-3 py-2">
                <input type="time" name="end_time" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT JADWAL --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeEditModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <h3 class="font-semibold text-lg mb-4">Edit Jadwal</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <select id="editSubject" name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <select id="editDay" name="day" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($days as $d)
                <option value="{{ $d }}">{{ $dayLabel[$d] }}</option>
                @endforeach
            </select>

            <div class="flex gap-2 mb-3">
                <input id="editStart" type="time" name="start_time" class="w-full border rounded px-3 py-2">
                <input id="editEnd" type="time" name="end_time" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Update</button>
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

function openAddModal(){ addModal.classList.remove('hidden') }
function closeAddModal(e){ if(!e || e.target.id==='addModal') addModal.classList.add('hidden') }

function openEditModal(id,subject,day,start,end){
    editModal.classList.remove('hidden');
    editForm.action="/schedules/"+id;
    editSubject.value=subject;
    editDay.value=day;
    editStart.value=start;
    editEnd.value=end;
}
function closeEditModal(e){ if(!e || e.target.id==='editModal') editModal.classList.add('hidden') }
</script>

@endsection