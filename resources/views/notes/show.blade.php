@extends('layouts.app')

@section('header', 'Note Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $note->title }}</h2>
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-0.5 text-sm font-medium rounded-full {{ $note->status === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $note->status }}
                    </span>
                    <span class="text-sm text-gray-500 bg-gray-50 px-2 py-0.5 rounded">{{ $note->category }}</span>
                    <span class="text-sm text-gray-400">• {{ $note->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('notes.edit', $note) }}" class="flex items-center gap-1 text-gray-600 hover:text-sky-600 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                    Edit
                </a>
            </div>
        </div>

        <div class="prose prose-sky max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $note->content }}
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
            <a href="{{ route('notes.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Back to Notes
            </a>

            <form action="{{ route('notes.destroy', $note) }}" method="POST" >
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                    Delete Note
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
