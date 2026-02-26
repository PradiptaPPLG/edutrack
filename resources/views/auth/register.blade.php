{{-- File: resources\views\auth\register.blade.php --}}
{{-- Halaman pendaftaran (registrasi) aplikasi Edutrack --}}

<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Bagian head: metadata, favicon, dan resource CSS --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Edutrack</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="http://127.0.0.1:8000/favicon.ico">
    
    {{-- Memuat Tailwind CSS dari CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Inter dan Material Symbols --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        /* Mengatur font utama */
        body { font-family: 'Inter', sans-serif; }
        /* Kursor pointer untuk tombol toggle password */
        .password-toggle {
            cursor: pointer;
            user-select: none;
        }
        /* Animasi fade in up */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Kelas untuk memicu animasi */
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-sky-50 to-indigo-100 flex items-center justify-center min-h-screen p-4">
    
    <!-- Container utama dengan animasi fade in up -->
    {{-- Elemen ini membungkus seluruh konten registrasi dan diberi animasi --}}
    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row animate-fade-in-up">
        
        {{-- Bagian kiri: menampilkan gambar latar dengan overlay teks --}}
        <div class="md:w-1/2 h-96 md:h-auto relative bg-black">
            {{-- Gambar latar belakang --}}
            <img src="{{ asset('images/register_edutrack.png') }}" alt="Register illustration" class="absolute inset-0 w-full h-full object-cover opacity-90">
            {{-- Overlay gradien agar teks lebih terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
            {{-- Teks selamat datang di pojok kiri bawah --}}
            <div class="absolute bottom-0 left-0 p-8 text-white">
                <span class="material-symbols-outlined text-5xl mb-2">school</span>
                <h2 class="text-4xl font-bold leading-tight">Bergabunglah<br>Dengan Kami</h2>
                <p class="text-sm mt-2 max-w-xs text-white/80">Buat akun dan mulailah pengalaman belajar yang lebih terstruktur bersama Edutrack.</p>
            </div>
        </div>

        {{-- Bagian kanan: form registrasi --}}
        <div class="md:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
            {{-- Judul form --}}
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h3>
                <p class="text-sm text-gray-500">Isi data diri Anda untuk mendaftar</p>
            </div>

            {{-- Form registrasi dengan method POST dan proteksi CSRF --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf {{-- Token keamanan CSRF Laravel --}}
                
                {{-- Field nama lengkap --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-sky-200 focus:border-sky-500 hover:border-sky-400 transition-all"
                           placeholder="Budi Santoso">
                    {{-- Menampilkan pesan error jika ada kesalahan pada nama --}}
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-sky-200 focus:border-sky-500 hover:border-sky-400 transition-all"
                           placeholder="nama@contoh.com">
                    {{-- Menampilkan pesan error jika ada kesalahan pada email --}}
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field password dengan tombol toggle --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <div class="relative mt-1">
                        <input type="password" name="password" id="password" required
                               class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-sky-200 focus:border-sky-500 hover:border-sky-400 transition-all pr-12"
                               placeholder="••••••••">
                        {{-- Tombol untuk menampilkan/menyembunyikan password --}}
                        <button type="button" onclick="togglePassword('password', this)" 
                                class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <span class="material-symbols-outlined">visibility_off</span>
                        </button>
                    </div>
                    {{-- Menampilkan pesan error jika ada kesalahan pada password --}}
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field konfirmasi password dengan tombol toggle --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                    <div class="relative mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-sky-200 focus:border-sky-500 hover:border-sky-400 transition-all pr-12"
                               placeholder="••••••••">
                        {{-- Tombol untuk menampilkan/menyembunyikan konfirmasi password --}}
                        <button type="button" onclick="togglePassword('password_confirmation', this)" 
                                class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <span class="material-symbols-outlined">visibility_off</span>
                        </button>
                    </div>
                </div>

                {{-- Teks persetujuan syarat dan ketentuan --}}
                <p class="text-xs text-gray-500">Dengan mendaftar, Anda menyetujui <a href="#" class="text-sky-600 hover:underline">Syarat dan Ketentuan</a> serta <a href="#" class="text-sky-600 hover:underline">Kebijakan Privasi</a> kami.</p>

                {{-- Tombol submit registrasi --}}
                <button type="submit"
                        class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-4 rounded-xl transition-all hover:scale-[1.02] hover:shadow-lg focus:ring-2 focus:ring-sky-300">
                    Daftar
                </button>
            </form>

            {{-- Pemisah "Atau" --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Atau</span>
                </div>
            </div>

            {{-- Tombol registrasi dengan Google (mengarah ke route google.redirect) --}}
            <a href="{{ route('google.redirect') }}" 
               class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-xl transition-all hover:scale-[1.02] hover:shadow-md">
                {{-- Logo Google (SVG) --}}
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Daftar dengan Google
            </a>

            {{-- Link menuju halaman login jika sudah punya akun --}}
            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-sky-600 hover:text-sky-700 transition-colors">Masuk di sini</a>
            </p>
        </div>
    </div>

    {{-- Script untuk fungsi toggle password (sama dengan yang di login) --}}
    <script>
        // Fungsi untuk mengubah tipe input password (text/password) dan ikonnya
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const iconSpan = button.querySelector('.material-symbols-outlined');
            
            if (input.type === 'password') {
                input.type = 'text';
                iconSpan.textContent = 'visibility';
            } else {
                input.type = 'password';
                iconSpan.textContent = 'visibility_off';
            }
        }
    </script>
</body>
</html>