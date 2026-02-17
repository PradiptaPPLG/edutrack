@extends('layouts.app')

@section('header', 'Tambah Mata Pelajaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('subjects.store') }}">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Pelajaran</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                    placeholder="Contoh: Pemrograman Web">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="color_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Warna</label>
                <div class="flex items-center gap-4">
                    <input type="color" name="color_code" id="color_code" value="{{ old('color_code', '#4F46E5') }}" required
                        class="h-10 w-20 p-1 border border-gray-300 rounded-lg cursor-pointer">
                    <span class="text-gray-500 text-sm">Pilih warna untuk mata pelajaran ini</span>
                </div>
                @error('color_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('subjects.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Simpan Mata Pelajaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
