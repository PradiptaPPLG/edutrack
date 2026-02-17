@extends('layouts.app')

@section('header', 'Catatan Saya')

@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('notes.create') }}" class="flex items-center gap-2 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Buat Catatan
        </a>
    </div>

    @if($notes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($notes as $note)
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col h-full">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-col gap-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full w-fit {{ $note->category === 'Personal' ? 'bg-blue-50 text-blue-600' : ($note->category === 'Work' ? 'bg-purple-50 text-purple-600' : 'bg-orange-50 text-orange-600') }}">
                                {{ $note->category }}
                            </span>
                            @if($note->subject)
                                <span class="px-2 py-1 text-xs font-medium rounded-full w-fit text-white" style="background-color: {{ $note->subject->color_code }}">
                                    {{ $note->subject->name }}
                                </span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400">{{ $note->created_at->format('d M Y') }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $note->title }}</h3>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">
                        {{ Str::limit($note->content, 100) }}
                    </p>

                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-50">
                        <a href="{{ route('notes.edit', $note) }}" class="p-2 text-gray-400 hover:text-sky-600 hover:bg-gray-50 rounded-full transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-gray-50 rounded-full transition-colors" title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-gray-100">
            <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">note_stack</span>
            <h3 class="text-lg font-medium text-gray-900">Belum ada catatan</h3>
            <p class="text-gray-500 mb-6">Buat catatan pertama Anda untuk mulai melacak pembelajaran.</p>
            <a href="{{ route('notes.create') }}" class="text-sky-600 font-medium hover:text-sky-700">Buat catatan baru &rarr;</a>
        </div>
    @endif
@endsection
