<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->search;
        $status  = $request->status;
        $kondisi = $request->kondisi;

        $barangs = Barang::query()
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%$search%")
                  ->orWhere('kode_barang', 'like', "%$search%")
                  ->orWhere('kategori', 'like', "%$search%");
            }))
            ->when($status,  fn($q) => $q->where('status', $status))
            ->when($kondisi, fn($q) => $q->where('kondisi', $kondisi))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('barang.index', compact('barangs', 'search', 'status', 'kondisi'));
    }

    public function create()
    {
        $kode = 'IT-' . str_pad((Barang::max('id') ?? 0) + 1, 3, '0', STR_PAD_LEFT);
        return view('barang.form', compact('kode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang'      => 'required|string|unique:barang,kode_barang',
            'nama_barang'      => 'required|string|max:200',
            'kategori'         => 'required|string|max:100',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status'           => 'required|in:Tersedia,Digunakan,Dipinjam,Rusak',
            'lokasi'           => 'required|string|max:200',
            'penanggung_jawab' => 'required|string|max:100',
            'jumlah_barang'    => 'required|integer|min:0',
            'spesifikasi'      => 'nullable|string',
            'keterangan'       => 'nullable|string',
            'foto'             => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumen'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $validated['waktu_input'] = now();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('barang/foto', 'public_direct');
        }
        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('barang/dokumen', 'public_direct');
        }

        Barang::create($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('barang.form', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang'      => 'required|string|unique:barang,kode_barang,' . $barang->id,
            'nama_barang'      => 'required|string|max:200',
            'kategori'         => 'required|string|max:100',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status'           => 'required|in:Tersedia,Digunakan,Dipinjam,Rusak',
            'lokasi'           => 'required|string|max:200',
            'penanggung_jawab' => 'required|string|max:100',
            'jumlah_barang'    => 'required|integer|min:0',
            'spesifikasi'      => 'nullable|string',
            'keterangan'       => 'nullable|string',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumen'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($barang->foto) Storage::disk('public_direct')->delete($barang->foto);
            $validated['foto'] = $request->file('foto')->store('barang/foto', 'public_direct');
        }
        if ($request->hasFile('dokumen')) {
            if ($barang->dokumen) Storage::disk('public_direct')->delete($barang->dokumen);
            $validated['dokumen'] = $request->file('dokumen')->store('barang/dokumen', 'public');
        }

        $barang->update($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto)    Storage::disk('public')->delete($barang->foto);
        if ($barang->dokumen) Storage::disk('public')->delete($barang->dokumen);
        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus!');
    }

    public function autocomplete(Request $request)
    {
        $term    = $request->get('term');
        $results = Barang::where('nama_barang', 'like', "%$term%")
            ->orWhere('kode_barang', 'like', "%$term%")
            ->limit(10)
            ->get(['id', 'nama_barang', 'kode_barang']);

        return response()->json($results->map(fn($b) => [
            'id'    => $b->id,
            'label' => $b->kode_barang . ' - ' . $b->nama_barang,
            'value' => $b->nama_barang,
        ]));
    }
}
