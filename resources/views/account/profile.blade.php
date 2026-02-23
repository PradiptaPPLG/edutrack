@extends('layouts.app')   {{--Menggunakan layout utama aplikasi--}}

@section('header', 'Profil Saya')  {{--Mengisi judul halaman--}}

@section('content')  {{--Memulai konten utama--}} 
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Profil</h2>

    {{-- Menampilkan pesan sukses dari session --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Menampilkan error validasi --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form update profile dengan method PUT --}}
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf  {{-- Token keamanan CSRF --}}
        @method('PUT')  {{-- Spoofing method PUT untuk update --}}

        {{-- ===== BAGIAN FOTO PROFIL DENGAN CROP ===== --}}
        <div class="mb-6 flex items-center gap-6">
            <div class="relative">
                {{-- Preview foto profil --}}
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 border-2 border-gray-300" id="profilePreview">
                    @if($user->profile_photo_path)
                        {{-- Jika sudah punya foto, tampilkan --}}
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        {{-- Jika belum, tampilkan inisial nama --}}
                        <div class="w-full h-full flex items-center justify-center bg-sky-100 text-primary text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                {{-- Tombol upload foto --}}
                <label for="profile_photo" class="absolute bottom-0 right-0 bg-primary text-white p-1 rounded-full cursor-pointer shadow">
                    <span class="material-symbols-outlined text-sm">edit</span>
                </label>
                <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*">
            </div>
            <div class="text-sm text-gray-500">
                <p>Format: JPG, PNG. Maks 2MB</p>
                <p>Foto akan ditampilkan di pojok kanan atas.</p>
            </div>
        </div>

        {{-- Form fields biasa --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary">
        </div>

        {{-- Password fields (opsional) --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 text-xs">(Kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" id="password" name="password"
                class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary">
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary">
        </div>

        {{-- Tombol aksi --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-sky-700">Simpan Perubahan</button>
        </div>
    </form>
</div>

{{-- ===== MODAL CROP FOTO ===== --}}
<div id="cropModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50" onclick="closeCropModal(event)">
    <div class="bg-white rounded-xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-semibold">Crop Foto</h3>
            <button onclick="closeCropModal()" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <div class="mb-4">
            <img id="cropImage" src="" alt="Preview" class="max-w-full">
        </div>
        <div class="flex justify-end gap-2 sticky bottom-0 bg-white pt-2">
            <button type="button" onclick="closeCropModal()" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">Batal</button>
            <button type="button" id="confirmCrop" class="px-4 py-2 bg-primary text-white rounded hover:bg-sky-700">Konfirmasi</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')  {{-- Menambahkan script ke stack --}}
<script>
let cropper;
const cropModal = document.getElementById('cropModal');
const cropImage = document.getElementById('cropImage');
const fileInput = document.getElementById('profile_photo');
const profilePreview = document.getElementById('profilePreview');
let currentFile;

// Event ketika user memilih file
fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validasi ukuran file (maks 2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File terlalu besar',
                text: 'Maksimal ukuran file 2MB'
            });
            fileInput.value = '';
            return;
        }

        // Validasi tipe file
        if (!file.type.match('image.*')) {
            Swal.fire({
                icon: 'error',
                title: 'Tipe file tidak didukung',
                text: 'Hanya file gambar (JPG, PNG) yang diperbolehkan'
            });
            fileInput.value = '';
            return;
        }

        currentFile = file;
        const reader = new FileReader();
        reader.onload = function(event) {
            cropImage.src = event.target.result;
            cropModal.classList.remove('hidden');
            if (cropper) cropper.destroy();
            // Inisialisasi Cropper.js untuk crop foto
            cropper = new Cropper(cropImage, {
                aspectRatio: 1 / 1,  // Rasio kotak (1:1)
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                cropBoxResizable: false,
                cropBoxMovable: true,
                minContainerWidth: 300,
                minContainerHeight: 300,
            });
        }
        reader.readAsDataURL(file);
    }
});

// Fungsi menutup modal crop
window.closeCropModal = function(event) {
    if (!event || event.target === cropModal) {
        cropModal.classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        fileInput.value = '';
    }
};

// Konfirmasi crop
document.getElementById('confirmCrop').addEventListener('click', function() {
    if (cropper) {
        // Mengambil hasil crop sebagai canvas
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        // Konversi canvas ke blob lalu ke File
        canvas.toBlob(function(blob) {
            const croppedFile = new File([blob], currentFile.name, {
                type: currentFile.type,
                lastModified: Date.now()
            });

            // Mengganti file input dengan hasil crop
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            fileInput.files = dataTransfer.files;

            // Update preview
            profilePreview.innerHTML = `<img src="${canvas.toDataURL()}" alt="Preview" class="w-full h-full object-cover">`;

            cropModal.classList.add('hidden');
            cropper.destroy();
            cropper = null;
        }, currentFile.type);
    }
});

// Toast error dari session
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}'
    });
@endif
</script>
@endpush