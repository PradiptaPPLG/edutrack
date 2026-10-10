@extends('layouts.app')
@section('header','Mata Pelajaran')

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

/* Hover effect untuk kartu */
.subject-card {
    transition: all 0.3s ease;
}

.subject-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>

{{-- HEADER --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Daftar Mata Pelajaran</h2>
    <button onclick="openAddModal()" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <span class="material-symbols-outlined">add</span> Tambah
    </button>
</div>

{{-- GRID CARD MATA PELAJARAN --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
@foreach($subjects as $subject)
<div class="bg-white rounded-xl shadow border p-4 relative fade-in-up subject-card" 
     style="transition-delay: {{ $loop->index * 0.15 }}s;">
    {{-- Strip warna di sisi kiri --}}
    <div class="absolute left-0 top-0 h-full w-2 rounded-l-xl" style="background: {{ $subject->color_code }}"></div>
    <h3 class="font-semibold text-lg">{{ $subject->name }}</h3>

    <div class="mt-4 flex justify-end gap-3 text-sm">
        <button onclick="openEditModal('{{ $subject->id }}','{{ $subject->name }}','{{ $subject->color_code }}')" 
        class="text-blue-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">edit</span> Edit
        </button>

        <form action="{{ route('subjects.destroy',$subject) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">delete</span> Hapus
            </button>
        </form>
    </div>
</div>
@endforeach
</div>

{{-- ===== MODAL TAMBAH MATA PELAJARAN ===== --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 modalBackdrop">
    <div class="bg-white rounded-xl p-6 w-96 relative modalBox">
        <button onclick="closeAddModal()" class="absolute right-3 top-3 text-gray-400 hover:text-black">✕</button>
        <h3 class="font-semibold text-lg mb-4">Tambah Mata Pelajaran</h3>

        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <input name="name" placeholder="Nama pelajaran" class="w-full border rounded px-3 py-2 mb-4">

            {{-- Palet warna dari database --}}
            <div class="flex gap-3 overflow-x-auto py-2 px-1 colorPalette">
                @foreach($colors as $color)
                <label class="shrink-0">
                    <input type="radio" name="color_code" value="{{ $color->color_code }}" class="hidden peer">
                    <div class="w-8 h-8 rounded-full border-2 cursor-pointer peer-checked:ring-4 ring-offset-2 ring-blue-400"
                    style="background:{{ $color->color_code }}"></div>
                </label>
                @endforeach

                <button type="button" onclick="openColorModal()" class="shrink-0 w-8 h-8 border rounded-full flex items-center justify-center text-gray-400">
                    <span class="material-symbols-outlined text-sm">more_horiz</span>
                </button>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL EDIT MATA PELAJARAN ===== --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 modalBackdrop">
    <div class="bg-white rounded-xl p-6 w-96 relative modalBox">
        <button onclick="closeEditModal()" class="absolute right-3 top-3 text-gray-400 hover:text-black">✕</button>
        <h3 class="font-semibold text-lg mb-4">Edit Mata Pelajaran</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input id="editName" name="name" class="w-full border rounded px-3 py-2 mb-4">

            <div class="flex gap-3 overflow-x-auto py-2 px-1 colorPaletteEdit">
                @foreach($colors as $color)
                <label class="shrink-0">
                    <input type="radio" name="color_code" value="{{ $color->color_code }}" class="hidden peer editColor">
                    <div class="w-8 h-8 rounded-full border-2 cursor-pointer peer-checked:ring-4 ring-offset-2 ring-blue-400"
                    style="background:{{ $color->color_code }}"></div>
                </label>
                @endforeach

                <button type="button" onclick="openColorModal()" class="shrink-0 w-8 h-8 border rounded-full flex items-center justify-center text-gray-400">
                    <span class="material-symbols-outlined text-sm">more_horiz</span>
                </button>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded">Batal</button>
                <button class="bg-primary text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL TAMBAH WARNA (AJAX) ===== --}}
<div id="colorModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 modalBackdrop">
    <div class="bg-white p-4 rounded-xl w-64 relative modalBox">
        <button onclick="closeColorModal()" class="absolute right-2 top-2 text-gray-400 hover:text-black">✕</button>
        <h4 class="font-semibold mb-2">Tambah Warna</h4>

        <input type="color" id="newColor" class="w-full h-12 border rounded">

        <button onclick="addColorAjax()" class="mt-3 w-full bg-primary text-white py-2 rounded">
            Tambah
        </button>
    </div>
</div>

{{-- TOAST SEDERHANA --}}
<div id="toast" class="fixed bottom-6 right-6 bg-green-600 text-white px-4 py-2 rounded shadow hidden"></div>

<style>
.colorPalette div, .colorPaletteEdit div { box-sizing: content-box; }
.modalBackdrop { cursor:pointer; }
.modalBox { cursor:default; }
</style>

<script>
const addModal = document.getElementById('addModal');
const editModal = document.getElementById('editModal');
const colorModal = document.getElementById('colorModal');
const editName = document.getElementById('editName');
const editForm = document.getElementById('editForm');
const toast = document.getElementById('toast');

// Fungsi buka/tutup modal
function openAddModal(){ addModal.classList.remove('hidden'); }
function closeAddModal(){ addModal.classList.add('hidden'); }

function openEditModal(id,name,color){
    editModal.classList.remove('hidden');
    editName.value=name;
    editForm.action="/subjects/"+id;
    // Set radio button yang sesuai dengan warna saat ini
    document.querySelectorAll('.editColor').forEach(r=>r.checked = (r.value === color));
}
function closeEditModal(){ editModal.classList.add('hidden'); }

function openColorModal(){ colorModal.classList.remove('hidden'); }
function closeColorModal(){ colorModal.classList.add('hidden'); }

// Klik di luar modal untuk menutup
document.querySelectorAll('.modalBackdrop').forEach(bg=>{
    bg.addEventListener('click', e=>{
        if(e.target.classList.contains('modalBackdrop')){
            bg.classList.add('hidden');
        }
    });
});

// Toast sederhana
function showToast(msg){
    toast.innerText = msg;
    toast.classList.remove('hidden');
    setTimeout(()=> toast.classList.add('hidden'),2000);
}

// AJAX untuk menambah warna baru
async function addColorAjax(){
    let color = document.getElementById('newColor').value;

    let res = await fetch('/colors/ajax',{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Content-Type':'application/json'
        },
        body: JSON.stringify({color_code: color})
    });

    let data = await res.json();

    // Tambahkan warna baru ke palet di kedua modal
    document.querySelectorAll('.colorPalette, .colorPaletteEdit').forEach(palette=>{
        let label = document.createElement('label');
        label.classList.add('shrink-0');
        label.innerHTML = `
            <input type="radio" name="color_code" value="${data.color_code}" class="hidden peer">
            <div class="w-8 h-8 rounded-full border-2 cursor-pointer peer-checked:ring-4 ring-offset-2 ring-blue-400"
            style="background:${data.color_code}"></div>`;
        palette.insertBefore(label, palette.lastElementChild);
        palette.scrollLeft = palette.scrollWidth;
    });

    showToast("Warna ditambahkan");
    closeColorModal();
}

// Trigger animasi fade-in-up setelah halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan class animated ke setiap kartu dengan delay (jika belum menggunakan style inline)
    // Sebenarnya kita sudah menggunakan transition-delay inline, jadi kita hanya perlu memicu animasi
    // dengan menambahkan class 'animated' setelah halaman siap.
    const cards = document.querySelectorAll('.subject-card');
    cards.forEach((card, index) => {
        // Gunakan timeout agar animasi tetap bertahap, meskipun sudah ada transition-delay di style
        setTimeout(() => {
            card.classList.add('animated');
        }, index * 50); // delay 150ms per kartu
    });
});
</script>

@endsection