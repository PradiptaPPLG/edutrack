@extends('layouts.app')

@section('header', 'Nilai')

@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('grades.create') }}" class="flex items-center gap-2 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Rekam Nilai
        </a>
    </div>

    @if($grades->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($grades as $grade)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full text-white" style="background-color: {{ $grade->subject->color_code }}">
                                    {{ $grade->subject->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $grade->activity_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold {{ $grade->score >= 75 ? 'text-green-600' : ($grade->score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $grade->score }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('grades.edit', $grade) }}" class="text-sky-600 hover:text-sky-900">Edit</a>
                                    <form action="{{ route('grades.destroy', $grade) }}" method="POST"  class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-gray-100">
            <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">grade</span>
            <h3 class="text-lg font-medium text-gray-900">Belum ada nilai direkam</h3>
            <p class="text-gray-500 mb-6">Mulai rekam nilai Anda untuk melacak performa.</p>
            <a href="{{ route('grades.create') }}" class="text-sky-600 font-medium hover:text-sky-700">Rekam nilai &rarr;</a>
        </div>
    @endif
@endsection
