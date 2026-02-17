@extends('layouts.app')

@section('header', 'Mata Pelajaran')

@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('subjects.create') }}" class="flex items-center gap-2 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Tambah Mata Pelajaran
        </a>
    </div>

    @if($subjects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($subjects as $subject)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white font-bold text-xl" style="background-color: {{ $subject->color_code }}">
                            {{ substr($subject->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $subject->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $subject->color_code }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('subjects.edit', $subject) }}" class="p-2 text-gray-400 hover:text-sky-600 hover:bg-gray-50 rounded-full transition-colors">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-gray-50 rounded-full transition-colors delete-btn">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-gray-100">
            <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">book_2</span>
            <h3 class="text-lg font-medium text-gray-900">Belum ada mata pelajaran</h3>
            <p class="text-gray-500 mb-6">Tambahkan mata pelajaran untuk mulai melacak kemajuan akademik Anda.</p>
            <a href="{{ route('subjects.create') }}" class="text-sky-600 font-medium hover:text-sky-700">Tambah mata pelajaran &rarr;</a>
        </div>
    @endif
@endsection
