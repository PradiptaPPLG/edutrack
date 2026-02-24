@extends('layouts.app')
@section('header','Catatan Saya')

@section('content')

{{-- ===== NOTIFIKASI XP ===== --}}
@if(session('success'))
    @if(str_contains(session('success'), '+3 XP'))
        <div class="mb-4 p-4 bg-gradient-to-r from-blue-400 to-indigo-500 text-white rounded-lg shadow-lg flex items-center gap-3">
            <span class="text-2xl">📝</span>
            <div class="flex-1">
                <p class="font-bold">{{ session('success') }}</p>
                <p class="text-sm text-blue-100">Total XP: {{ number_format(Auth::user()->xp) }} | Level {{ Auth::user()->level }}</p>
            </div>
            <span class="text-3xl">✨</span>
        </div>
    @elseif(str_contains(session('success'), '+5 XP'))
        <div class="mb-4 p-4 bg-gradient-to-r from-green-400 to-emerald-500 text-white rounded-lg shadow-lg flex items-center gap-3 animate-pulse">
            <span class="text-2xl">🎉</span>
            <div class="flex-1">
                <p class="font-bold">{{ session('success') }}</p>
                <p class="text-sm text-green-100">Total XP: {{ number_format(Auth::user()->xp) }} | Level {{ Auth::user()->level }}</p>
            </div>
            <span class="text-3xl">🏆</span>
        </div>
    @else
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
@endif
{{-- ===== END NOTIFIKASI XP ===== --}}

{{-- Header dengan tombol tambah --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Catatan Saya</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <span class="material-symbols-outlined">note_add</span> Tambah
    </button>
</div>

{{-- ===== REKAP CATATAN ===== --}}
@php
    $totalNotes = $notes->count();
    $completedNotes = $notes->where('status', 'Completed')->count();
    $inProgressNotes = $notes->where('status', 'In Progress')->count();
    $persenCompleted = $totalNotes > 0 ? round(($completedNotes / $totalNotes) * 100) : 0;
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <!-- Card Total Catatan -->
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Catatan</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalNotes }}</h3>
        </div>
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
            <span class="material-symbols-outlined text-2xl">notes</span>
        </div>
    </div>

    <!-- Card Catatan Selesai -->
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Selesai</p>
            <h3 class="text-3xl font-bold text-green-600">{{ $completedNotes }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ $persenCompleted }}% dari total</p>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
            <span class="material-symbols-outlined text-2xl">checklist</span>
        </div>
    </div>

    <!-- Card Catatan Dalam Proses -->
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-indigo-500 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Dalam Proses</p>
            <h3 class="text-3xl font-bold text-indigo-600">{{ $inProgressNotes }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ 100 - $persenCompleted }}% dari total</p>
        </div>
        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
            <span class="material-symbols-outlined text-2xl">pending_actions</span>
        </div>
    </div>
</div>

{{-- GRID NOTES --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
@foreach($notes as $n)
@php
$color = $n->status == 'Completed' ? '#22c55e' : '#6366f1';
@endphp

<div class="bg-white rounded-xl shadow border p-4 relative border-l-8" style="border-left-color: {{ $color }}; border-left-width: 8px;">
    <h3 class="font-semibold text-lg">{{ $n->title }}</h3>
    <p class="text-xs text-gray-500">{{ $n->category }}</p>

    @if($n->subject)
        <p class="text-xs mt-1 text-gray-400">Mapel: {{ $n->subject->name }}</p>
    @endif

    <p class="text-sm mt-2 line-clamp-3">{{ $n->content }}</p>

    <span class="inline-block mt-2 px-2 py-1 text-xs rounded"
        style="background: {{ $color }}20; color: {{ $color }}">
        {{ $n->status }}
    </span>

    <div class="mt-4 flex justify-end gap-3 text-sm">
        <button onclick="openEditModal('{{ $n->id }}','{{ $n->title }}','{{ $n->category }}','{{ $n->content }}','{{ $n->status }}','{{ $n->subject_id }}')"
            class="text-blue-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">edit</span> Edit
        </button>

        <form action="{{ route('notes.destroy',$n) }}" method="POST" class="inline">
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

{{-- MODAL TAMBAH CATATAN --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeAddModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <h3 class="font-semibold text-lg mb-4">Tambah Catatan</h3>

        <form action="{{ route('notes.store') }}" method="POST">
            @csrf

            <select name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                <option value="">Tanpa Mapel</option>
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <input name="title" placeholder="Judul" class="w-full border rounded px-3 py-2 mb-3">
            <input name="category" placeholder="Kategori" class="w-full border rounded px-3 py-2 mb-3">

            <textarea name="content" placeholder="Isi catatan..." class="w-full border rounded px-3 py-2 mb-3"></textarea>

            <select name="status" class="w-full border rounded px-3 py-2">
                <option>In Progress</option>
                <option>Completed</option>
            </select>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT CATATAN --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50" onclick="closeEditModal(event)">
    <div class="bg-white rounded-xl p-6 w-96" onclick="event.stopPropagation()">
        <h3 class="font-semibold text-lg mb-4">Edit Catatan</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <select id="editSubject" name="subject_id" class="w-full border rounded px-3 py-2 mb-3">
                <option value="">Tanpa Mapel</option>
                @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <input id="editTitle" name="title" class="w-full border rounded px-3 py-2 mb-3">
            <input id="editCategory" name="category" class="w-full border rounded px-3 py-2 mb-3">
            <textarea id="editContent" name="content" class="w-full border rounded px-3 py-2 mb-3"></textarea>

            <select id="editStatus" name="status" class="w-full border rounded px-3 py-2">
                <option>In Progress</option>
                <option>Completed</option>
            </select>

            <div class="flex justify-end gap-2 mt-4">
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
const editTitle = document.getElementById('editTitle');
const editCategory = document.getElementById('editCategory');
const editContent = document.getElementById('editContent');
const editStatus = document.getElementById('editStatus');
const editSubject = document.getElementById('editSubject');

function openAddModal(){ addModal.classList.remove('hidden') }
function closeAddModal(e){ if(!e || e.target.id==='addModal') addModal.classList.add('hidden') }

function openEditModal(id,title,category,content,status,subject){
    editModal.classList.remove('hidden');
    editForm.action="/notes/"+id;
    editTitle.value=title;
    editCategory.value=category;
    editContent.value=content;
    editStatus.value=status;
    editSubject.value=subject || '';
}
function closeEditModal(e){ if(!e || e.target.id==='editModal') editModal.classList.add('hidden') }
</script>

@endsection