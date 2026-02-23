@extends('layouts.app')

@section('header', 'Kehadiran')

@section('content')
<div class="max-w-6xl mx-auto p-4">

{{-- FORM ADD --}}
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <form method="POST" action="{{ route('attendances.store') }}" class="grid grid-cols-4 gap-3">
        @csrf

        <select name="subject_id" class="border rounded px-3 py-2">
            @foreach($subjects as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>

        <input type="date" name="date" class="border rounded px-3 py-2">

        <select name="status" class="border rounded px-3 py-2">
            <option value="Present">Hadir</option>
            <option value="Excused">Izin</option>
            <option value="Absent">Alpa</option>
        </select>

        <input type="text" name="notes" placeholder="Catatan" class="border rounded px-3 py-2">

        <button class="bg-primary text-white px-4 py-2 rounded col-span-4 mt-2">
            Tambah Kehadiran
        </button>
    </form>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Mapel</th>
                <th class="p-3">Status</th>
                <th class="p-3">Catatan</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($attendances as $a)
            <tr class="border-t">
                <td class="p-3">{{ $a->date->format('d M Y') }}</td>
                <td class="p-3">{{ $a->subject->name }}</td>

                <td class="p-3">
                    @if($a->status == 'Present')
                        <span class="text-green-600 font-semibold">Hadir</span>
                    @elseif($a->status == 'Excused')
                        <span class="text-yellow-600 font-semibold">Izin</span>
                    @else
                        <span class="text-red-600 font-semibold">Alpa</span>
                    @endif
                </td>

                <td class="p-3">{{ $a->notes }}</td>

                <td class="p-3">
                    <form action="{{ route('attendances.destroy',$a) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
@endsection