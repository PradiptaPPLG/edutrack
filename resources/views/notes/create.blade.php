@extends('layouts.app')

@section('header', 'Buat Catatan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('notes.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                        placeholder="Contoh: Rumus Matematika">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran (Opsional)</label>
                    <select name="subject_id" id="subject_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                        <option value="">Tanpa Mata Pelajaran</option>
                        @foreach(\Illuminate\Support\Facades\Auth::user()->subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <input type="text" name="category" id="category" value="{{ old('category') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                        placeholder="Contoh: Backend">
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                        <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>Sedang Berjalan</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                <textarea name="content" id="content" rows="6" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                    placeholder="Tulis catatan belajar Anda di sini...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('notes.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
