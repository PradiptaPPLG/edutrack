@extends('layouts.app')
@section('header', 'Edit Mata Pelajaran')

@section('content')
<form method="POST" action="{{ route('subjects.update', $subject) }}" class="max-w-md bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')

    <label class="block mb-2">Nama</label>
    <input name="name" value="{{ $subject->name }}" class="w-full border p-2 rounded mb-4">

    <label class="block mb-2">Warna</label>
    <input type="color" name="color_code" value="{{ $subject->color_code }}" class="mb-4">

    <button class="bg-primary text-white px-4 py-2 rounded">Update</button>
</form>
@endsection