@extends('layouts.app')

@section('header', 'Jadwal Saya')

@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('schedules.create') }}" class="flex items-center gap-2 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Tambah Jadwal
        </a>
    </div>

    @if($schedules->count() > 0)
        <div class="space-y-6">
            @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $dayNames = [
                    'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
                ];
            @endphp

            @foreach($days as $day)
                @php $daySchedules = $schedules->where('day', $day); @endphp
                @if($daySchedules->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800">{{ $dayNames[$day] }}</h3>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($daySchedules as $schedule)
                                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="text-sm font-medium text-gray-500 w-24">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 flex items-center gap-2">
                                                <span class="w-3 h-3 rounded-full" style="background-color: {{ $schedule->subject->color_code }}"></span>
                                                {{ $schedule->subject->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('schedules.edit', $schedule) }}" class="p-2 text-gray-400 hover:text-sky-600 rounded-full transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 rounded-full transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl border border-gray-100">
            <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">calendar_month</span>
            <h3 class="text-lg font-medium text-gray-900">Belum ada jadwal</h3>
            <p class="text-gray-500 mb-6">Atur jadwal kelas mingguan Anda.</p>
            <a href="{{ route('schedules.create') }}" class="text-sky-600 font-medium hover:text-sky-700">Tambah jadwal &rarr;</a>
        </div>
    @endif
@endsection
