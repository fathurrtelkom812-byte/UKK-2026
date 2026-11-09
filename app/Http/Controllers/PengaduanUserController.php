<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanUserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk select option
        $categories = Category::all();

        // 2. Ambil pengaduan milik siswa yang sedang login saja
        $query = Pengaduan::with('category')
            ->where('user_id', Auth::id());

        // Pencarian jika ada request search
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $pengaduans = $query->latest()->get();

        return view('pengaduan.index', compact('categories', 'pengaduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'lokasi'      => 'required|string|max:255',
            'deskripsi'   => 'required|string',
        ], [
            'category_id.required' => 'Pilih kategori pengaduan terlebih dahulu.',
            'lokasi.required'      => 'Lokasi kerusakan harus diisi.',
            'deskripsi.required'   => 'Deskripsi kerusakan harus diisi.',
        ]);

        Pengaduan::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'lokasi'      => $request->lokasi,
            'deskripsi'   => $request->deskripsi,
            'status'      => 'menunggu', // Default status awal
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }
}