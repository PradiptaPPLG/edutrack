<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - EduTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-sky-600">school</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Akun</h1>
            <p class="text-gray-500 text-sm">Bergabung dengan EduTrack untuk mengelola pembelajaran Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="Budi Santoso">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="siswa@contoh.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-sky-500 focus:border-sky-500" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors">
                Daftar
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-sky-600 hover:text-sky-500">Masuk di sini</a>
        </div>
    </div>
</body>
</html>
