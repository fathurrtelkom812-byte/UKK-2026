<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarana Pengaduan Sekolah</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <a class="navbar-brand font-weight-bold" href="#">📢 Sarana Pengaduan Sekolah</a>
        <div class="ml-auto text-white">
            <span class="mr-3">Halo, {{ Auth::user()->name ?? 'Siswa' }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Validasi Error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <!-- Form Buat Pengaduan -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold mb-3">Buat Pengaduan</h4>
                        <p class="text-muted small">Laporkan kendala fasilitas sekolah dengan memilih kategori yang sesuai.</p>
                        
                        <form action="{{ route('pengaduan.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Pilih Kategori Pengaduan</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Cth: Kelas XII RPL 1" required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Kerusakan</label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan detail kendala..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-dark btn-block font-weight-bold">Kirim Laporan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Pengaduan Masuk -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold mb-3">Daftar Pengaduan Masuk</h4>

                        <!-- Form Pencarian -->
                        <form action="{{ route('pengaduan.index') }}" method="GET" class="form-inline mb-3">
                            <input type="text" name="search" class="form-control mr-2 flex-grow-1" placeholder="Cari lokasi/keluhan..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-dark">Cari</button>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kategori & Lokasi</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Feedback / Tanggapan Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengaduans as $p)
                                        <tr>
                                            <td>
                                                <strong>{{ $p->category->nama ?? '-' }}</strong><br>
                                                <small class="text-muted">{{ $p->lokasi }}</small>
                                            </td>
                                            <td>{{ $p->deskripsi }}</td>
                                            <td>
                                                @if($p->status == 'menunggu')
                                                    <span class="badge badge-warning text-dark">Menunggu</span>
                                                @elseif($p->status == 'proses')
                                                    <span class="badge badge-info">Proses</span>
                                                @else
                                                    <span class="badge badge-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>{{ $p->feedback ?? 'Belum ada tanggapan' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data pengaduan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>