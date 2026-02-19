<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EduTrack') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

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
                        primary: '#0284c7', // Sky 600
                        secondary: '#10B981', // Emerald 500
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
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <span class="text-xl font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">school</span>
                    EduTrack
                </span>
            </div>

            <nav class="p-4 space-y-6 overflow-y-auto">
                <!-- Dashboard -->
                <div>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </div>

                <!-- Akademik -->
                <div>
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Akademik</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('subjects.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">book_2</span>
                            Mata Pelajaran
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('schedules.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">calendar_month</span>
                            Jadwal
                        </a>
                    </div>
                </div>

                <!-- Study Hub -->
                <div>
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pusat Belajar</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('notes.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">edit_note</span>
                            Catatan Saya
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('assignments.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">assignment</span>
                            Tugas
                        </a>
                    </div>
                </div>

                <!-- Performa -->
                <div>
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Performa</h3>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('grades.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">grade</span>
                            Nilai
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('attendances.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined">verified_user</span>
                            Kehadiran
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 mt-auto border-t border-gray-200 absolute bottom-0 w-64">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full text-left text-gray-600 hover:text-red-600 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <h1 class="text-lg font-semibold text-gray-800">
                    @yield('header', 'Dashboard')
                </h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">Selamat datang, <strong>{{ Auth::user()->name }}</strong></span>
                    <div class="w-8 h-8 bg-sky-100 rounded-full flex items-center justify-center text-primary font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-8">
                <!-- Flash Message removed (handled by SweetAlert2) -->

                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

        // Delete Confirmation
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

        // Incoming Feature Menu Toast
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
</body>
</html>
