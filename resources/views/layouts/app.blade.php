<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Edutrack') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="http://127.0.0.1:8000/favicon.ico">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Alpine.js untuk interaktivitas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Cropper.js untuk crop foto -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0284c7',
                        secondary: '#10B981',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    @auth
    
    <!-- Sidebar Fixed -->
    <aside class="fixed top-0 left-0 w-64 h-screen bg-white border-r border-gray-200 flex flex-col z-20">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-gray-200 flex-shrink-0">
            <span class="text-xl font-bold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined">school</span>
                Edutrack
            </span>
        </div>

        <!-- Navigasi sidebar -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-6">
            <!-- Dashboard -->
            <div>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>
            </div>

            <!-- Akademik -->
            <div>
                <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Akademik</h3>
                <div class="space-y-1">
                    <a href="{{ route('subjects.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('subjects.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">book_2</span>
                        Mata Pelajaran
                    </a>
                    <a href="{{ route('schedules.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('schedules.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Jadwal
                    </a>
                </div>
            </div>

            <!-- Study Hub -->
            <div>
                <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pusat Belajar</h3>
                <div class="space-y-1">
                    <a href="{{ route('notes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('notes.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">edit_note</span>
                        Catatan Saya
                    </a>
                    <a href="{{ route('assignments.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('assignments.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">assignment</span>
                        Tugas
                    </a>
                </div>
            </div>

            <!-- Performa -->
            <div>
                <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Performa</h3>
                <div class="space-y-1">
                    <a href="{{ route('grades.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('grades.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">grade</span>
                        Nilai
                    </a>
                    <a href="{{ route('attendances.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('attendances.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">verified_user</span>
                        Kehadiran
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Header Fixed -->
    <header class="fixed top-0 left-64 right-0 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 z-10">
        <h1 class="text-lg font-semibold text-gray-800">
            @yield('header', 'Dashboard')
        </h1>
        <div class="flex items-center gap-4">
            <!-- Dropdown User dengan Alpine.js -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                    <span class="text-sm text-gray-600">Selamat datang, <strong>{{ Auth::user()->name }}</strong></span>
                    <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center {{ Auth::user()->profile_photo_path ? '' : 'bg-sky-100' }}">
                        @php
                            $photoPath = Auth::user()->profile_photo_path;
                            $photoUrl = null;
                            if ($photoPath) {
                                if (Storage::disk('public')->exists($photoPath)) {
                                    $photoUrl = asset('storage/' . $photoPath);
                                }
                            }
                        @endphp
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <span class="text-primary font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-200" style="display: none;">
                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">account_circle</span> Profile
                    </a>
                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">settings</span> Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">logout</span> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-64 pt-16 min-h-screen">
        <div class="p-8">
            @yield('content')
        </div>
    </main>
    @endauth

    @guest
    <main class="min-h-screen">
        @yield('content')
    </main>
    @endguest

    <!-- Script global -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toast notification
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Session flash messages
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Delete confirmation untuk semua form dengan method DELETE
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-btn') || e.target.closest('form[method="POST"] button[type="submit"]')) {
                const button = e.target.closest('button');
                const form = button.closest('form');

                if (form && form.querySelector('input[name="_method"][value="DELETE"]')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            }
        });

        // Fitur yang belum tersedia
        document.querySelectorAll('a[href="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                Toast.fire({
                    icon: 'info',
                    title: 'Fitur belum tersedia'
                });
            });
        });
    </script>
    
    @stack('scripts')
</body> 
</html>