<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarana Pengaduan Sekolah - Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Header Navbar -->
    <nav class="bg-slate-900 text-white shadow-md p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">📢 Sarana Pengaduan Sekolah</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-300">Halo, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="max-w-6xl mx-auto my-8 px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: Form Buat Pengaduan -->
        <div class="bg-white p-6 rounded-xl shadow-md md:col-span-1 h-fit">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Buat Pengaduan</h2>
            <p class="text-gray-600 mb-4 text-sm">Laporkan kendala fasilitas sekolah dengan memilih kategori yang sesuai.</p>

            @if(session('success'))
                <div class="mb-4 p-3 text-sm text-green-800 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pengaduan.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kategori Pengaduan</label>
                    <select name="category_id" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="lokasi" placeholder="Cth: Kelas XII RPL 1" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kerusakan</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan detail kendala..." required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-amber-500 focus:border-amber-500"></textarea>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-2.5 rounded-lg hover:bg-slate-800 transition text-sm">
                    Kirim Laporan
                </button>
            </form>
        </div>

        <!-- KOLOM KANAN: Tabel Riwayat Pengaduan -->
        <div class="bg-white p-6 rounded-xl shadow-md md:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Daftar Pengaduan Masuk</h2>
                
                <!-- Search Box -->
                <form action="{{ route('pengaduan.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lokasi/keluhan..." class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm">
                    <button type="submit" class="bg-gray-200 px-3 py-1.5 rounded-lg text-sm hover:bg-gray-300">Cari</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 border-b">
                            <th class="p-3">Kategori & Lokasi</th>
                            <th class="p-3">Deskripsi</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Feedback / Tanggapan Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pengaduans as $item)
                            <tr>
                                <td class="p-3">
                                    <span class="font-semibold block text-gray-800">{{ $item->category->nama ?? '-' }}</span>
                                    <span class="text-xs text-gray-500">📍 {{ $item->lokasi }}</span>
                                </td>
                                <td class="p-3 text-gray-600 max-w-xs truncate">{{ $item->deskripsi }}</td>
                                <td class="p-3">
                                    @php
                                        $badgeColor = match(strtolower($item->status)) {
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'proses' => 'bg-blue-100 text-blue-800',
                                            default => 'bg-amber-100 text-amber-800',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="p-3 text-gray-600 text-xs">
                                    {{ $item->feedback ?? 'Belum ada tanggapan' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-gray-400">Belum ada data pengaduan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $pengaduans->links() }}
            </div>
        </div>

    </div>

</body>
</html>