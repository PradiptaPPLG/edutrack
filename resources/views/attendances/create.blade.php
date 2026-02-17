@extends('layouts.app')

@section('header', 'Rekam Absensi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('attendances.store') }}">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                        <option value="Present" {{ old('status') == 'Present' ? 'selected' : '' }}>Hadir</option>
                        <option value="Excused" {{ old('status') == 'Excused' ? 'selected' : '' }}>Izin</option>
                        <option value="Absent" {{ old('status') == 'Absent' ? 'selected' : '' }}>Absen/Alpha</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500"
                    placeholder="Alasan ketidakhadiran atau detail lainnya...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('attendances.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
