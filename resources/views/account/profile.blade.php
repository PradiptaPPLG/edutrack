@extends('layouts.app')

@section('header', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto">
    
    {{-- ===== BADGE CARD (KANAN ATAS) ===== --}}
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white mb-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- FOTO BADGE/MEDALI (BUKAN FOTO PROFIL) --}}
                <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-white shadow-md bg-white/10 flex items-center justify-center">
                    <img src="{{ asset('images/medals/level' . $user->level . '.png') }}" 
                         alt="Level {{ $user->level }} Badge" 
                         class="w-24 h-24 object-contain"
                         onerror="this.onerror=null; this.src='{{ asset('images/medals/level1.png') }}';">
                </div>
                
                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-purple-100 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            
            {{-- Level & XP --}}
            <div class="text-right">
                <div class="flex items-center gap-2">
                    <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1">
                        <span>⭐</span> Level {{ $user->level }}
                    </span>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ number_format($user->xp) }} XP
                    </span>
                </div>
                
                {{-- Nama tingkatan --}}
                @php
                    $currentTier = \App\Models\LevelTier::getTier($user->level);
                @endphp
                <p class="text-sm text-purple-200 mt-1 italic">
                    "{{ $currentTier['name'] }}"
                </p>
                
                {{-- Next level progress --}}
                @php
                    $nextTier = \App\Models\LevelTier::getNextLevelRequirement($user->level);
                    $gamification = new \App\Services\GamificationService($user);
                    $progress = $gamification->getProgressToNextLevel();
                @endphp
                
                @if($nextTier)
                <div class="mt-2 w-48">
                    <div class="flex justify-between text-xs text-purple-200 mb-1">
                        <span>Level {{ $user->level + 1 }}</span>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="h-1.5 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                    <p class="text-xs text-purple-200 mt-1">
                        {{ $nextTier['xp'] - $user->xp }} XP lagi
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Form Edit Profil --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-semibold mb-6">Edit Profil</h3>

        {{-- Menampilkan pesan sukses --}}
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

        {{-- Form update profile --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PUT')

            {{-- Upload Foto --}}
            <div class="mb-6 flex items-center gap-6">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 border-2 border-gray-300" id="profilePreview">
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-sky-100 text-primary text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <label for="profile_photo" class="absolute bottom-0 right-0 bg-primary text-white p-1 rounded-full cursor-pointer shadow">
                        <span class="material-symbols-outlined text-sm">edit</span>
                    </label>
                    <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*">
                </div>
                <div class="text-sm text-gray-500">
                    <p>Format: JPG, PNG. Maks 2MB</p>
                    <p>Foto akan ditampilkan di profil.</p>
                </div>
            </div>

            {{-- Form fields --}}
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

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password Baru <span class="text-gray-400 text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                </label>
                <input type="password" id="password" name="password"
                    class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Konfirmasi Password Baru
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full border rounded px-3 py-2 focus:ring-primary focus:border-primary">
            </div>

            {{-- Tombol aksi --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-sky-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Crop Foto (SAMA PERSIS) --}}
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

@push('scripts')
<script>
// Script crop foto (SAMA PERSIS)
let cropper;
const cropModal = document.getElementById('cropModal');
const cropImage = document.getElementById('cropImage');
const fileInput = document.getElementById('profile_photo');
const profilePreview = document.getElementById('profilePreview');
let currentFile;

fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File terlalu besar',
                text: 'Maksimal ukuran file 2MB'
            });
            fileInput.value = '';
            return;
        }

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
            cropper = new Cropper(cropImage, {
                aspectRatio: 1 / 1,
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

document.getElementById('confirmCrop').addEventListener('click', function() {
    if (cropper) {
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        canvas.toBlob(function(blob) {
            const croppedFile = new File([blob], currentFile.name, {
                type: currentFile.type,
                lastModified: Date.now()
            });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            fileInput.files = dataTransfer.files;

            profilePreview.innerHTML = `<img src="${canvas.toDataURL()}" alt="Preview" class="w-full h-full object-cover">`;

            cropModal.classList.add('hidden');
            cropper.destroy();
            cropper = null;
        }, currentFile.type);
    }
});

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}'
    });
@endif
</script>
@endpush