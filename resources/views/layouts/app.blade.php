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
        
        <!-- Mini Games - HANYA GAME HUB -->
        <div>
            <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2"> Mini Games</h3>
            <div class="space-y-1">
                <a href="{{ route('games.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('games.*') ? 'bg-sky-50 text-primary font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    <span class="material-symbols-outlined">sports_esports</span>
                    Game Hub
                </a>
            </div>
        </div>
    </nav>
</aside>

    <!-- Header Fixed -->
    <header class="fixed top-0 left-64 right-0 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 z-50">
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
<div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-200" style="display: none;">
    
    <!-- User info dengan gamifikasi -->
    <div class="px-4 py-3 border-b border-gray-100">
        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
        
        <!-- Level & XP Badge -->
        <div class="mt-2 flex items-center gap-2">
            <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full font-medium">
                Level {{ Auth::user()->level }}
            </span>
            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">
                {{ number_format(Auth::user()->xp) }} XP
            </span>
        </div>
        
        <!-- Current Tier Name -->
        @php
            $currentTier = \App\Models\LevelTier::getTier(Auth::user()->level);
        @endphp
        <p class="text-xs text-gray-600 mt-1 italic truncate">
            "{{ $currentTier['name'] }}"
        </p>
        
        <!-- Progress bar ke next level -->
        @php
            $nextTier = \App\Models\LevelTier::getNextLevelRequirement(Auth::user()->level);
            $gamification = new \App\Services\GamificationService(Auth::user());
            $progress = $gamification->getProgressToNextLevel();
        @endphp
        
        @if($nextTier)
        <div class="mt-2">
            <div class="flex justify-between text-xs text-gray-500 mb-1">
                <span>Progress ke Level {{ Auth::user()->level + 1 }}</span>
                <span>{{ $progress }}%</span>
            </div>
            <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-500 to-yellow-500 rounded-full" 
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>
        @endif
        
    </div>
    
    {{-- STREAK SECTION - Menggunakan StreakService --}}
    @php
        $streak = Auth::user()->streak ?? 0;
        $streakInfo = \App\Services\StreakService::getStreakInfo($streak);
    @endphp

    @if($streakInfo['level'] > 0)
    <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-amber-50">
        <div class="flex items-center gap-3">
            <!-- Icon Streak -->
            @if($streakInfo['icon'])
            <img src="{{ $streakInfo['icon'] }}" class="w-8 h-8" alt="{{ $streakInfo['name'] }}">
            @else
            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                <span class="text-orange-600 text-lg">🔥</span>
            </div>
            @endif
            
            <!-- Info Streak -->
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-800">
                        {{ $streak }} Hari
                    </span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-orange-200 text-orange-800 font-medium">
                        {{ $streakInfo['name'] }}
                    </span>
                </div>
                
                <!-- Progress ke level streak berikutnya -->
                @if($streakInfo['next_level'])
                @php
                    $progressPercentage = min(100, round(($streak / $streakInfo['next_level']) * 100));
                @endphp
                <div class="mt-1">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Menuju {{ $streakInfo['next_level'] }} hari</span>
                        <span>{{ $progressPercentage }}%</span>
                    </div>
                    <div class="h-1 bg-gray-200 rounded-full mt-1 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-orange-400 to-red-500 rounded-full" 
                             style="width: {{ $progressPercentage }}%"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @elseif($streak > 0)
    {{-- Streak tanpa level (1-2 hari) --}}
    <div class="px-4 py-2 border-b border-gray-100 bg-gray-50">
        <div class="flex items-center gap-2">
            <span class="text-orange-500">🔥</span>
            <span class="text-sm text-gray-700">{{ $streak }} Day Streak</span>
            <span class="text-xs text-gray-500 ml-auto">Mulai streak!</span>
        </div>
    </div>
    @endif
    
    <!-- Menu Items (seterusnya tetap sama) -->
    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
        <span class="material-symbols-outlined text-sm">account_circle</span> Profile
    </a>
    
    <a href="{{ route('achievements') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 border-t border-gray-100">
        <span class="material-symbols-outlined text-sm text-yellow-500">emoji_events</span> 
        <span class="flex-1">Achievements</span>
        <span class="bg-purple-100 text-purple-700 text-xs px-2 py-0.5 rounded-full">{{ Auth::user()->level }}/16</span>
    </a>
    
    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
        <span class="material-symbols-outlined text-sm">settings</span> Settings
    </a>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2 border-t border-gray-100">
            <span class="material-symbols-outlined text-sm">logout</span> Logout
        </button>
    </form>
    <!-- Di dalam sidebar, setelah menu Performa atau sebelum Logout -->

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

    @if(session('info'))
        Toast.fire({
            icon: 'info',
            title: '{{ session('info') }}'
        });
    @endif

    // Delete confirmation - KHUSUS UNTUK FORM DELETE (bukan form biasa)
    document.addEventListener('click', function(e) {
        // Cari tombol submit dalam form
        const button = e.target.closest('button[type="submit"]');
        if (!button) return;
        
        const form = button.closest('form');
        if (!form) return;
        
        // CEK PENTING: Apakah ini form logout? (actionnya ke route logout)
        if (form.action && form.action.includes('logout')) {
            return; // Langsung submit, tanpa konfirmasi
        }
        
        // Cek apakah ini form DELETE (ada input _method dengan value DELETE)
        const methodInput = form.querySelector('input[name="_method"][value="DELETE"]');
        
        if (methodInput) {
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
        // Jika bukan form DELETE, biarkan berjalan normal (termasuk form logout)
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