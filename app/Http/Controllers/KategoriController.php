<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $kategoris = Kategori::withCount('barang')
            ->when($search, fn($q) => $q->where('nama_kategori', 'like', "%$search%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('kategori.form', ['kategori' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        Kategori::create($request->only('nama_kategori', 'deskripsi'));
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.form', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id,
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori->update($request->only('nama_kategori', 'deskripsi'));
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->barang()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih ada barang terkait!');
        }
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
