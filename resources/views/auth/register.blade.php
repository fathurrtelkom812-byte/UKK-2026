<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sarana Pengaduan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-8">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-slate-900 mb-2 text-center">📝 Daftar Akun Siswa</h2>
        <p class="text-gray-500 text-sm text-center mb-6">Lengkapi data diri untuk mulai membuat pengaduan</p>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Cth: Muh Fatih" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Cth: 12345" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Cth: XII RPL 1" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@sekolah.com" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-slate-900 focus:border-slate-900">
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-2.5 rounded-lg hover:bg-slate-800 transition text-sm">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login di sini</a>
        </p>
    </div>
</body>
</html>