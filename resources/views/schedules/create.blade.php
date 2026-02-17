@extends('layouts.app')

@section('header', 'Tambah Jadwal')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('schedules.store') }}">
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
                <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                <select name="day" id="day" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    <option value="" disabled selected>Pilih Hari</option>
                    @php
                        $days = [
                            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
                        ];
                    @endphp
                    @foreach($days as $en => $id)
                        <option value="{{ $en }}" {{ old('day') == $en ? 'selected' : '' }}>{{ $id }}</option>
                    @endforeach
                </select>
                @error('day')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('schedules.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
