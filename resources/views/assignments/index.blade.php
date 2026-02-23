@extends('layouts.app')

@section('header','Tugas')

@section('content')

{{-- Header dengan tombol tambah --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Daftar Tugas</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <span class="material-symbols-outlined">add</span> Tambah
    </button>
</div>

{{-- GRID CARD TUGAS --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
@foreach($assignments as $a)
@php
    // Menentukan warna border berdasarkan status
    if($a->status == 'Completed'){
        $color = '#22c55e'; // hijau untuk tugas yang sudah selesai
    } else {
        $color = '#f59e0b'; // orange untuk tugas pending
    }
@endphp

{{-- Card tugas dengan border kiri berwarna --}}
<div class="bg-white rounded-xl shadow border p-4 relative border-l-8"
     style="border-left-color: {{ $color }}; border-left-width: 8px;">

    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-semibold text-lg">{{ $a->title }}</h3>
            <p class="text-sm text-gray-500">{{ $a->subject->name }}</p>
        </div>

        <!-- Dot status -->
        <div class="w-4 h-4 rounded-full" style="background: {{ $color }}"></div>
    </div>

    <p class="text-xs mt-2">Deadline: {{ $a->due_date->format('d M Y') }}</p>

    {{-- Badge status dengan warna sesuai --}}
    <span class="inline-block mt-2 px-2 py-1 text-xs rounded"
          style="background: {{ $color }}20; color: {{ $color }}">
        {{ $a->status }}
    </span>

    {{-- Tombol aksi --}}
    <div class="mt-4 flex justify-end gap-3 text-sm">
        <button onclick="openEditModal('{{ $a->id }}','{{ $a->title }}','{{ $a->subject_id }}','{{ $a->due_date->format('Y-m-d') }}','{{ $a->status }}')"
            class="text-blue-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">edit</span> Edit
        </button>

        {{-- Form hapus dengan method DELETE --}}
        <form action="{{ route('assignments.destroy',$a) }}" method="POST" class="inline">
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

{{-- ===== MODAL TAMBAH TUGAS ===== --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeAddModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <h3 class="font-semibold text-lg mb-4">Tambah Tugas</h3>

        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf

            <select name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <input name="title" placeholder="Judul tugas" class="w-full border rounded px-3 py-2 mb-3">
            <input type="date" name="due_date" class="w-full border rounded px-3 py-2 mb-3">

            <select name="status" class="w-full border rounded px-3 py-2">
                <option>Pending</option>
                <option>Completed</option>
            </select>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL EDIT TUGAS ===== --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeEditModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <h3 class="font-semibold text-lg mb-4">Edit Tugas</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <select id="editSubject" name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <input id="editTitle" name="title" class="w-full border rounded px-3 py-2 mb-3">
            <input id="editDate" type="date" name="due_date" class="w-full border rounded px-3 py-2 mb-3">

            <select id="editStatus" name="status" class="w-full border rounded px-3 py-2">
                <option>Pending</option>
                <option>Completed</option>
            </select>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript untuk modal --}}
<script>
function openAddModal(){ document.getElementById('addModal').classList.remove('hidden') }
function closeAddModal(e){ if(!e || e.target.id==='addModal') document.getElementById('addModal').classList.add('hidden') }

function openEditModal(id,title,subject,date,status){
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editForm').action="/assignments/"+id;
    document.getElementById('editTitle').value=title;
    document.getElementById('editSubject').value=subject;
    document.getElementById('editDate').value=date;
    document.getElementById('editStatus').value=status;
}
function closeEditModal(e){ if(!e || e.target.id==='editModal') document.getElementById('editModal').classList.add('hidden') }
</script>

@endsection