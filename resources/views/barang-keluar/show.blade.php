    @extends('layouts.app')

@section('title', 'Detail Barang Keluar')

@section('content')

<div class="page-title">
    <i class="bi bi-info-circle"></i> Detail Barang Keluar
</div>

<div style="margin-bottom:16px;display:flex;gap:8px">
    <a href="{{ route('barang-keluar.index') }}"
       style="background:#fff;color:#666;border:1px solid #ddd;border-radius:6px;padding:7px 16px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:5px">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="detail-section">
            <div class="detail-section-header">
                <i class="bi bi-box-arrow-up"></i> Informasi Pengeluaran
            </div>
            <div class="detail-section-body">

                <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f0f0f0">
                    <div style="width:60px;height:60px;background:#eef0fb;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-box-arrow-up" style="font-size:1.8rem;color:#3b2db5"></i>
                    </div>
                    <div>
                        <div style="font-size:18px;font-weight:700;color:#222">{{ $barangKeluar->no_keluar }}</div>
                        <div style="font-size:13px;color:#888">{{ $barangKeluar->tanggal_keluar->format('d F Y') }}</div>
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap">
                    <div class="detail-item">
                        <div class="d-label">Nama Barang</div>
                        <div class="d-value">{{ $barangKeluar->barang->nama_barang ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Kode Barang</div>
                        <div class="d-value" style="color:#3b2db5;font-weight:600">
                            {{ $barangKeluar->barang->kode_barang ?? '—' }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Jumlah Keluar</div>
                        <div class="d-value">
                            <span style="font-weight:700;color:#222">{{ $barangKeluar->jumlah }}</span>
                            <span style="font-size:12px;color:#888;margin-left:4px">unit</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Tanggal Keluar</div>
                        <div class="d-value">{{ $barangKeluar->tanggal_keluar->format('d F Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Penerima</div>
                        <div class="d-value">{{ $barangKeluar->penerima }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Bagian / Divisi</div>
                        <div class="d-value">{{ $barangKeluar->bagian ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Keperluan</div>
                        <div class="d-value">{{ $barangKeluar->keperluan ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Petugas</div>
                        <div class="d-value">{{ $barangKeluar->petugas ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Dicatat Pada</div>
                        <div class="d-value">{{ $barangKeluar->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                @if($barangKeluar->keterangan)
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid #f0f0f0">
                    <div style="font-size:11px;color:#aaa;margin-bottom:4px">Keterangan</div>
                    <div style="font-size:13px;color:#555">{{ $barangKeluar->keterangan }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Info stok barang saat ini --}}
        @if($barangKeluar->barang)
        <div class="detail-section mb-3">
            <div class="detail-section-header">
                <i class="bi bi-box-seam"></i> Stok Barang Saat Ini
            </div>
            <div class="detail-section-body" style="text-align:center;padding:20px">
                <div style="font-size:38px;font-weight:700;color:#222;line-height:1">
                    {{ $barangKeluar->barang->jumlah_barang }}
                </div>
                <div style="font-size:12px;color:#aaa;margin-top:4px">unit tersisa</div>
                <div style="margin-top:10px">
                    @php $sc=['Tersedia'=>'badge-tersedia','Digunakan'=>'badge-digunakan','Dipinjam'=>'badge-dipinjam','Rusak'=>'badge-rusak']; @endphp
                    <span class="{{ $sc[$barangKeluar->barang->status] ?? '' }}">
                        {{ $barangKeluar->barang->status }}
                    </span>
                </div>
            </div>
        </div>
        @endif

        {{-- Foto --}}
        @if($barangKeluar->foto)
        <div class="detail-section mb-3">
            <div class="detail-section-header">
                <i class="bi bi-image"></i> Foto Barang Keluar
            </div>
            <div class="detail-section-body" style="text-align:center">
                <img src="{{ Storage::url($barangKeluar->foto) }}" alt="Foto"
                     style="max-height:200px;border-radius:8px;object-fit:cover;width:100%">
            </div>
        </div>
        @endif

        {{-- Dokumen --}}
        @if($barangKeluar->dokumen)
        <div class="detail-section mb-3">
            <div class="detail-section-header">
                <i class="bi bi-file-earmark"></i> Dokumen
            </div>
            <div class="detail-section-body">
                <a href="{{ Storage::url($barangKeluar->dokumen) }}" target="_blank"
                   style="display:block;text-align:center;background:#eef0fb;border:1px solid #d0d4f0;color:#3b2db5;border-radius:6px;padding:10px;font-size:13px;text-decoration:none;font-weight:600">
                    <i class="bi bi-download me-2"></i>Unduh Dokumen
                </a>
            </div>
        </div>
        @endif

        {{-- Hapus --}}
        <div class="detail-section">
            <div class="detail-section-header" style="color:#c62828">
                <i class="bi bi-exclamation-triangle"></i> Zona Berbahaya
            </div>
            <div class="detail-section-body">
                <p style="font-size:12px;color:#aaa;margin-bottom:12px">
                    Menghapus akan mengembalikan stok sebanyak
                    <strong>{{ $barangKeluar->jumlah }} unit</strong>.
                </p>
                <button type="button"
                        onclick="confirmDelete('{{ route('barang-keluar.destroy', $barangKeluar) }}', 'Hapus {{ addslashes($barangKeluar->no_keluar) }}? Stok akan dikembalikan {{ $barangKeluar->jumlah }} unit.')"
                        style="width:100%;background:#ffebee;border:1px solid #ffcdd2;color:#c62828;border-radius:6px;padding:9px;font-size:13px;cursor:pointer;font-weight:600">
                    <i class="bi bi-trash me-2"></i>Hapus Data Ini
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
