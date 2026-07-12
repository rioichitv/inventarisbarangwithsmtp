<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->search;
        $tanggal = $request->tanggal;

        $data = BarangKeluar::with('barang')
            ->when($search, function ($q) use ($search) {
                $q->where('no_keluar', 'like', "%$search%")
                  ->orWhere('penerima', 'like', "%$search%")
                  ->orWhereHas('barang', fn($q2) =>
                      $q2->where('nama_barang', 'like', "%$search%")
                         ->orWhere('kode_barang', 'like', "%$search%")
                  );
            })
            ->when($tanggal, fn($q) => $q->whereDate('tanggal_keluar', $tanggal))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('barang-keluar.index', compact('data', 'search', 'tanggal'));
    }

    public function create()
    {
        $barangs   = Barang::orderBy('nama_barang')->get();
        $no_keluar = 'BK-' . str_pad((BarangKeluar::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);
        return view('barang-keluar.form', compact('barangs', 'no_keluar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_keluar'      => 'required|string|unique:barang_keluar,no_keluar',
            'barang_id'      => 'required|exists:barang,id',
            'jumlah'         => 'required|integer|min:1',
            'penerima'       => 'required|string|max:100',
            'bagian'         => 'nullable|string|max:100',
            'tanggal_keluar' => 'required|date',
            'keperluan'      => 'nullable|string|max:200',
            'keterangan'     => 'nullable|string',
            'petugas'        => 'nullable|string|max:100',
            'foto'           => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumen'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);

        if ($validated['jumlah'] > $barang->jumlah_barang) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia (' . $barang->jumlah_barang . ' unit).'])
                ->withInput();
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('keluar/foto', 'public_direct');
        }
        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('keluar/dokumen', 'public_direct');
        }

        $barang->decrement('jumlah_barang', $validated['jumlah']);
        BarangKeluar::create($validated);

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dicatat!');
    }

    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load('barang');
        return view('barang-keluar.show', compact('barangKeluar'));
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('barang-keluar.form', compact('barangKeluar', 'barangs'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $validated = $request->validate([
            'no_keluar'      => 'required|string|unique:barang_keluar,no_keluar,' . $barangKeluar->id,
            'barang_id'      => 'required|exists:barang,id',
            'jumlah'         => 'required|integer|min:1',
            'penerima'       => 'required|string|max:100',
            'bagian'         => 'nullable|string|max:100',
            'tanggal_keluar' => 'required|date',
            'keperluan'      => 'nullable|string|max:200',
            'keterangan'     => 'nullable|string',
            'petugas'        => 'nullable|string|max:100',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumen'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $barangLama = Barang::findOrFail($barangKeluar->barang_id);
        $barangLama->increment('jumlah_barang', $barangKeluar->jumlah);

        $barangBaru = Barang::findOrFail($validated['barang_id']);
        if ($validated['jumlah'] > $barangBaru->jumlah_barang) {
            $barangLama->decrement('jumlah_barang', $barangKeluar->jumlah);
            return back()
                ->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia (' . $barangBaru->jumlah_barang . ' unit).'])
                ->withInput();
        }

        if ($request->hasFile('foto')) {
            if ($barangKeluar->foto) Storage::disk('public_direct')->delete($barangKeluar->foto);
            $validated['foto'] = $request->file('foto')->store('keluar/foto', 'public_direct');
        }
        if ($request->hasFile('dokumen')) {
            if ($barangKeluar->dokumen) Storage::disk('public_direct')->delete($barangKeluar->dokumen);
            $validated['dokumen'] = $request->file('dokumen')->store('keluar/dokumen', 'public_direct');
        }

        $barangBaru->decrement('jumlah_barang', $validated['jumlah']);
        $barangKeluar->update($validated);

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Data barang keluar berhasil diperbarui!');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        if ($barangKeluar->foto)    Storage::disk('public_direct')->delete($barangKeluar->foto);
        if ($barangKeluar->dokumen) Storage::disk('public_direct')->delete($barangKeluar->dokumen);

        $barang = Barang::find($barangKeluar->barang_id);
        if ($barang) $barang->increment('jumlah_barang', $barangKeluar->jumlah);

        $barangKeluar->delete();
        return back()->with('success', 'Data barang keluar berhasil dihapus!');
    }
}
