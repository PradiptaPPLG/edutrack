@extends('layouts.app')

@section('header', 'Kehadiran')

@section('content')

<style>
/* Animasi fade in up - sama seperti di dashboard */
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.3, 1), 
                transform 0.8s cubic-bezier(0.2, 0.9, 0.3, 1);
}

.fade-in-up.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Hover effect untuk stat card */
.stat-card {
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Animasi untuk sel kalender */
.calendar-cell {
    transition: all 0.2s ease;
}
.calendar-cell:hover {
    transform: scale(1.05);
    z-index: 10;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
</style>

<div class="max-w-7xl mx-auto p-4">

{{-- Statistik Ringkas dengan animasi --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    @php
        $totalHadir = $attendances->where('status','Present')->count();
        $totalIzin = $attendances->where('status','Excused')->count();
        $totalAlpa = $attendances->where('status','Absent')->count();
        $totalSemua = $attendances->count();
        $persenHadir = $totalSemua > 0 ? round(($totalHadir / $totalSemua) * 100, 1) : 0;
    @endphp
    
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-green-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Total Hadir</p>
        <p class="text-2xl font-bold">{{ $totalHadir }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-yellow-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Total Izin</p>
        <p class="text-2xl font-bold">{{ $totalIzin }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-red-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Total Alpa</p>
        <p class="text-2xl font-bold">{{ $totalAlpa }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 border-l-4 border-blue-500 stat-card fade-in-up">
        <p class="text-sm text-gray-500">Kehadiran</p>
        <p class="text-2xl font-bold">{{ $persenHadir }}%</p>
    </div>
</div>

{{-- Tabs: List View / Calendar View --}}
<div class="mb-4 flex gap-2 fade-in-up">
    <button onclick="switchView('list')" id="tabList" class="px-4 py-2 bg-primary text-white rounded-l-lg">Daftar</button>
    <button onclick="switchView('calendar')" id="tabCalendar" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-r-lg">Kalender</button>
</div>

{{-- FORM ADD (selalu tampil) --}}
<div class="bg-white p-4 rounded-xl shadow mb-6 fade-in-up">
    <form method="POST" action="{{ route('attendances.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
        @csrf
        <select name="subject_id" class="border rounded px-3 py-2">
            @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>
        <input type="date" name="date" class="border rounded px-3 py-2" value="{{ now()->format('Y-m-d') }}">
        <select name="status" class="border rounded px-3 py-2">
            <option value="Present">Hadir</option>
            <option value="Excused">Izin</option>
            <option value="Absent">Alpa</option>
        </select>
        <input type="text" name="notes" placeholder="Catatan (opsional)" class="border rounded px-3 py-2">
        <button class="bg-primary text-white px-4 py-2 rounded">
            Tambah
        </button>
    </form>
</div>

{{-- LIST VIEW --}}
<div id="listView" class="bg-white rounded-xl shadow overflow-hidden fade-in-up">
    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Mapel</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Catatan</th>
                <th class="p-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances->sortByDesc('date') as $a)
            <tr class="border-t hover:bg-gray-50 transition-colors">
                <td class="p-3">{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</td>
                <td class="p-3">{{ $a->subject->name }}</td>
                <td class="p-3">
                    @if($a->status == 'Present')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">Hadir</span>
                    @elseif($a->status == 'Excused')
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">Izin</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">Alpa</span>
                    @endif
                </td>
                <td class="p-3">{{ $a->notes ?: '-' }}</td>
                <td class="p-3">
                    <form action="{{ route('attendances.destroy',$a) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Hapus data kehadiran?')">
                            <span class="material-symbols-outlined text-base">delete</span>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-8 text-center text-gray-400">
                    Belum ada data kehadiran
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- CALENDAR VIEW --}}
<div id="calendarView" class="hidden bg-white rounded-xl shadow p-6 fade-in-up">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">{{ now()->format('F Y') }}</h3>
        <div class="flex gap-2">
            <button class="p-2 hover:bg-gray-100 rounded">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="p-2 hover:bg-gray-100 rounded">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </div>
    </div>

    {{-- Nama hari --}}
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach(['Sen','Sel','Rab','Kam','Jum','Sab','Min'] as $day)
            <div class="text-center text-sm font-semibold text-gray-500">{{ $day }}</div>
        @endforeach
    </div>

    {{-- Grid kalender --}}
    <div class="grid grid-cols-7 gap-1">
        @php
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            $startDay = $startOfMonth->dayOfWeekIso; // 1 (Senin) - 7 (Minggu)
            $daysInMonth = $endOfMonth->day;
            
            // Kumpulkan data kehadiran per tanggal
            $attendanceByDate = [];
            foreach($attendances as $a) {
                $date = \Carbon\Carbon::parse($a->date)->format('Y-m-d');
                if (!isset($attendanceByDate[$date])) {
                    $attendanceByDate[$date] = [];
                }
                $attendanceByDate[$date][] = $a;
            }
        @endphp

        {{-- Sel kosong sebelum tanggal 1 --}}
        @for($i = 1; $i < $startDay; $i++)
            <div class="aspect-square p-1 bg-gray-50 rounded-lg opacity-50"></div>
        @endfor

        {{-- Tanggal dalam bulan --}}
        @for($day = 1; $day <= $daysInMonth; $day++)
            @php
                $currentDate = now()->setDay($day)->format('Y-m-d');
                $dayAttendances = $attendanceByDate[$currentDate] ?? [];
                $hadirCount = collect($dayAttendances)->where('status','Present')->count();
                $izinCount = collect($dayAttendances)->where('status','Excused')->count();
                $alpaCount = collect($dayAttendances)->where('status','Absent')->count();
                $totalCount = count($dayAttendances);
            @endphp

            <div class="aspect-square p-1 border rounded-lg hover:shadow-lg transition-all calendar-cell relative group {{ $totalCount > 0 ? 'bg-gray-50' : '' }}">
                <div class="text-right text-sm">{{ $day }}</div>
                
                {{-- Indikator status --}}
                @if($totalCount > 0)
                    <div class="flex gap-0.5 mt-1">
                        @if($hadirCount > 0)
                            <div class="w-2 h-2 rounded-full bg-green-500" title="Hadir: {{ $hadirCount }}"></div>
                        @endif
                        @if($izinCount > 0)
                            <div class="w-2 h-2 rounded-full bg-yellow-500" title="Izin: {{ $izinCount }}"></div>
                        @endif
                        @if($alpaCount > 0)
                            <div class="w-2 h-2 rounded-full bg-red-500" title="Alpa: {{ $alpaCount }}"></div>
                        @endif
                    </div>
                @endif

                {{-- Tooltip detail --}}
                @if($totalCount > 0)
                <div class="absolute bottom-full left-0 mb-2 w-48 bg-black text-white text-xs rounded-lg p-2 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-20">
                    <p class="font-semibold mb-1">{{ \Carbon\Carbon::parse($currentDate)->format('d M Y') }}</p>
                    @foreach($dayAttendances as $att)
                        <div class="flex justify-between gap-2 border-b border-gray-700 py-1">
                            <span>{{ $att->subject->name }}</span>
                            <span class="
                                @if($att->status == 'Present') text-green-300
                                @elseif($att->status == 'Excused') text-yellow-300
                                @else text-red-300
                                @endif
                            ">
                                @if($att->status == 'Present') H
                                @elseif($att->status == 'Excused') I
                                @else A
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        @endfor
    </div>

    {{-- Legend --}}
    <div class="flex gap-4 mt-6 text-sm">
        <div class="flex items-center gap-1">
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <span>Hadir</span>
        </div>
        <div class="flex items-center gap-1">
            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
            <span>Izin</span>
        </div>
        <div class="flex items-center gap-1">
            <div class="w-3 h-3 rounded-full bg-red-500"></div>
            <span>Alpa</span>
        </div>
    </div>
</div>

</div>

<script>
// Switch view antara list dan calendar
function switchView(view) {
    const listView = document.getElementById('listView');
    const calendarView = document.getElementById('calendarView');
    const tabList = document.getElementById('tabList');
    const tabCalendar = document.getElementById('tabCalendar');
    
    if (view === 'list') {
        listView.classList.remove('hidden');
        calendarView.classList.add('hidden');
        tabList.classList.remove('bg-gray-200', 'text-gray-700');
        tabList.classList.add('bg-primary', 'text-white');
        tabCalendar.classList.remove('bg-primary', 'text-white');
        tabCalendar.classList.add('bg-gray-200', 'text-gray-700');
    } else {
        listView.classList.add('hidden');
        calendarView.classList.remove('hidden');
        tabCalendar.classList.remove('bg-gray-200', 'text-gray-700');
        tabCalendar.classList.add('bg-primary', 'text-white');
        tabList.classList.remove('bg-primary', 'text-white');
        tabList.classList.add('bg-gray-200', 'text-gray-700');
    }
}

// Animasi fade-in-up setelah halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.classList.add('animated');
        }, index * 100); // delay 100ms per elemen
    });
});
</script>

@endsection