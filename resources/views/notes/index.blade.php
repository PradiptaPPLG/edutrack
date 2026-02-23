@extends('layouts.app')
@section('header','Catatan Saya')

@section('content')

{{-- Header dengan tombol tambah --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Catatan Saya</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <span class="material-symbols-outlined">note_add</span> Tambah
    </button>
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