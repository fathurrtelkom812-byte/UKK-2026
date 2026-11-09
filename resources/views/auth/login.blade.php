<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sarana Pengaduan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-slate-900 mb-2 text-center">🔑 Masuk Akun</h2>
        <p class="text-gray-500 text-sm text-center mb-6">Silakan login untuk Melaporkan Pengaduan</p>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-2.5 rounded-lg hover:bg-slate-800 transition text-sm">
                Login
            </button>
        </form>

        <!-- Garis Pemisah -->
        <div class="relative flex py-4 items-center">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-xs">Atau</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <!-- Tombol Button Register / Daftar -->
        <a href="{{ route('register') }}" class="w-full block text-center bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg hover:bg-gray-300 transition text-sm">
            Belum punya akun? Daftar di sini
        </a>
    </div>
</body>
</html>