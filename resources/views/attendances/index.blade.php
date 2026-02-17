@extends('layouts.app')

@section('header', 'Absensi')

@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('attendances.create') }}" class="flex items-center gap-2 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Rekam Absensi
        </a>
    </div>

    @if($attendances->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($attendances as $attendance)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $attendance->date->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full text-white" style="background-color: {{ $attendance->subject->color_code }}">
                                    {{ $attendance->subject->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $attendance->status === 'Present' ? 'bg-green-100 text-green-800' :
                                      ($attendance->status === 'Excused' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $attendance->status === 'Present' ? 'Hadir' : ($attendance->status === 'Excused' ? 'Izin' : 'Absen') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $attendance->notes ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('attendances.edit', $attendance) }}" class="text-sky-600 hover:text-sky-900">Edit</a>
                                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST"  class="inline-block">
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
            <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">verified_user</span>
            <h3 class="text-lg font-medium text-gray-900">Belum ada rekam absensi</h3>
            <p class="text-gray-500 mb-6">Pantau kehadiran kelas Anda di sini.</p>
            <a href="{{ route('attendances.create') }}" class="text-sky-600 font-medium hover:text-sky-700">Rekam absensi &rarr;</a>
        </div>
    @endif
@endsection
