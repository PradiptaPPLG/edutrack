@extends('layouts.app')

@section('header', 'Tambah Tugas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('assignments.store') }}">
            @csrf

            <div class="mb-6">
                <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    <option value="" disabled selected>Pilih Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                    placeholder="Contoh: Esai Sejarah">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Tenggat Waktu</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Belum Selesai</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('assignments.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Simpan Tugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
