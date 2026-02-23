<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Edutrack</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="http://127.0.0.1:8000/favicon.ico">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-sky-50 to-indigo-100 flex items-center justify-center min-h-screen p-4">
    
    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        
        {{-- Sisi kiri: gambar dengan overlay teks --}}
        <div class="md:w-1/2 h-96 md:h-auto relative bg-black">
            <img src="{{ asset('images/register_edutrack.png') }}" alt="Register illustration" class="absolute inset-0 w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-8 text-white">
                <span class="material-symbols-outlined text-5xl mb-2">school</span>
                <h2 class="text-4xl font-bold leading-tight">Bergabunglah<br>Dengan Kami</h2>
                <p class="text-sm mt-2 max-w-xs text-white/80">Buat akun dan mulailah pengalaman belajar yang lebih terstruktur bersama Edutrack.</p>
            </div>
        </div>

        {{-- Sisi kanan: form register --}}
        <div class="md:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h3>
                <p class="text-sm text-gray-500">Isi data diri Anda untuk mendaftar</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                
                {{-- Field nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-sky-200 focus:border-sky-500 hover:border-sky-400 transition-all"
                           placeholder="Budi Santoso">
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
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-sky-200 focus:border-sky-500 hover:border-sky-400 transition-all"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Field konfirmasi password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-sky-200 focus:border-sky-500 hover:border-sky-400 transition-all"
                           placeholder="••••••••">
                </div>

                {{-- Teks persetujuan --}}
                <p class="text-xs text-gray-500">Dengan mendaftar, Anda menyetujui <a href="#" class="text-sky-600 hover:underline">Syarat dan Ketentuan</a> serta <a href="#" class="text-sky-600 hover:underline">Kebijakan Privasi</a> kami.</p>

                {{-- Tombol submit --}}
                <button type="submit"
                        class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-4 rounded-xl transition-all hover:scale-[1.02] hover:shadow-lg focus:ring-2 focus:ring-sky-300">
                    Daftar
                </button>
            </form>

            {{-- Link ke login --}}
            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-sky-600 hover:text-sky-700 transition-colors">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>