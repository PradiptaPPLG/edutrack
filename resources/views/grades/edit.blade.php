@extends('layouts.app')

@section('header', 'Edit Nilai')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('grades.update', $grade) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <select name="subject_id" id="subject_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    <option value="" disabled>Pilih Mata Pelajaran</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $grade->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="activity_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Aktivitas</label>
                <input type="text" name="activity_name" id="activity_name" value="{{ old('activity_name', $grade->activity_name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                @error('activity_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="score" class="block text-sm font-medium text-gray-700 mb-1">Nilai (0-100)</label>
                <input type="number" name="score" id="score" value="{{ old('score', $grade->score) }}" required min="0" max="100" step="0.01"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                @error('score')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('grades.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Perbarui Nilai
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
