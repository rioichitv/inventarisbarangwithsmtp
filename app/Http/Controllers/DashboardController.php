<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang  = Barang::count();
        $totalJumlah  = Barang::sum('jumlah_barang');
        $tersedia     = Barang::where('status', 'Tersedia')->count();
        $digunakan    = Barang::where('status', 'Digunakan')->count();
        $dipinjam     = Barang::where('status', 'Dipinjam')->count();
        $rusak        = Barang::where('kondisi', '!=', 'Baik')->count();

        $barangTerbaru = Barang::orderByDesc('created_at')->take(6)->get();
        $barangRusak   = Barang::where('kondisi', '!=', 'Baik')->take(5)->get();

        // Statistik per kategori (manual input)
        $perKategori = Barang::selectRaw('kategori, COUNT(*) as total')
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', compact(
            'totalBarang', 'totalJumlah', 'tersedia', 'digunakan',
            'dipinjam', 'rusak', 'barangTerbaru', 'barangRusak', 'perKategori'
        ));
    }
}
