@extends('layouts.app')

@section('header', 'Pengaturan')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h2 class="text-2xl font-bold mb-6">Pengaturan Aplikasi</h2>

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- KKM (Kriteria Ketuntasan Minimal) -->
        <div class="mb-6">
            <label for="kkm" class="block text-sm font-medium text-gray-700 mb-1">KKM (Kriteria Ketuntasan Minimal)</label>
            <input type="number" id="kkm" name="kkm" min="0" max="100" value="{{ old('kkm', $user->kkm) }}" required
                class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary">
            <p class="text-xs text-gray-400 mt-1">Nilai di bawah KKM akan dianggap belum tuntas.</p>
            @error('kkm') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        <!-- Quote motivasi -->
        <div class="mb-6">
            <label for="quote" class="block text-sm font-medium text-gray-700 mb-1">Kutipan Motivasi</label>
            <textarea id="quote" name="quote" rows="3"
                class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary"
                placeholder="Hanya mereka yang terus melangkah maju yang akan mencapai garis finish. Teruslah belajar dan berkembang!">{{ old('quote', $user->quote) }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Kutipan ini akan ditampilkan di halaman dashboard.</p>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-sky-700">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection