@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')

<div class="page-title">
    <i class="bi bi-info-circle"></i> Detail Barang
</div>

<div style="margin-bottom:16px;display:flex;gap:8px">
    <a href="{{ route('barang.edit', $barang) }}"
       style="background:#FF9800;color:#fff;border:none;border-radius:6px;padding:7px 18px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:5px">
        <i class="bi bi-pencil"></i> Edit
    </a>
    <a href="{{ route('barang.index') }}"
       style="background:#fff;color:#666;border:1px solid #ddd;border-radius:6px;padding:7px 16px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:5px">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="detail-section">
            <div class="detail-section-header">
                <i class="bi bi-box-seam"></i> Informasi Barang
            </div>
            <div class="detail-section-body">

                {{-- Header --}}
                <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #f0f0f0">
                    @if($barang->foto)
                        <img src="{{ Storage::url($barang->foto) }}" alt="Foto"
                             style="width:70px;height:70px;object-fit:cover;border-radius:12px;flex-shrink:0">
                    @else
                        <div style="width:70px;height:70px;background:#eef0fb;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="bi bi-cpu" style="font-size:2rem;color:#5c6bc0"></i>
                        </div>
                    @endif
                    <div>
                        <div style="font-size:18px;font-weight:700;color:#222;margin-bottom:4px">{{ $barang->nama_barang }}</div>
                        <div style="font-size:13px;color:#3b2db5;font-weight:600;margin-bottom:8px">{{ $barang->kode_barang }}</div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            @php
                                $kc=['Baik'=>'badge-baik','Rusak Ringan'=>'badge-ringan','Rusak Berat'=>'badge-berat'];
                                $sc=['Tersedia'=>'badge-tersedia','Digunakan'=>'badge-digunakan','Dipinjam'=>'badge-dipinjam','Rusak'=>'badge-rusak'];
                            @endphp
                            <span class="{{ $kc[$barang->kondisi] ?? '' }}">{{ $barang->kondisi }}</span>
                            <span class="{{ $sc[$barang->status] ?? '' }}">{{ $barang->status }}</span>
                            @if($barang->kategori)
                            <span style="background:#eef0fb;color:#3b2db5;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600">
                                {{ $barang->kategori }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Detail grid --}}
                <div style="display:flex;flex-wrap:wrap">
                    <div class="detail-item">
                        <div class="d-label">Kategori</div>
                        <div class="d-value">{{ $barang->kategori ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Jumlah Barang</div>
                        <div class="d-value">
                            <span style="font-weight:700;color:#222">{{ $barang->jumlah_barang }}</span>
                            <span style="font-size:12px;color:#888;margin-left:4px">unit</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Lokasi</div>
                        <div class="d-value">{{ $barang->lokasi ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Penanggung Jawab</div>
                        <div class="d-value">{{ $barang->penanggung_jawab ?? '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Waktu Input</div>
                        <div class="d-value">{{ $barang->waktu_input ? $barang->waktu_input->format('d/m/Y H:i:s') : '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Ditambahkan</div>
                        <div class="d-value">{{ $barang->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                @if($barang->spesifikasi)
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid #f0f0f0">
                    <div style="font-size:11px;color:#aaa;margin-bottom:4px">Spesifikasi Teknis</div>
                    <div style="font-size:13px;color:#555;white-space:pre-line">{{ $barang->spesifikasi }}</div>
                </div>
                @endif

                @if($barang->keterangan)
                <div style="margin-top:12px;padding-top:12px;border-top:1px solid #f0f0f0">
                    <div style="font-size:11px;color:#aaa;margin-bottom:4px">Keterangan</div>
                    <div style="font-size:13px;color:#555">{{ $barang->keterangan }}</div>
                </div>
                @endif

            </div>
        </div>
    </div>

    <div class="col-md-4">

        @if($barang->foto)
        <div class="detail-section mb-3">
            <div class="detail-section-header">
                <i class="bi bi-image"></i> Foto Barang
            </div>
            <div class="detail-section-body" style="text-align:center">
                <img src="{{ Storage::url($barang->foto) }}" alt="Foto"
                     style="max-height:220px;border-radius:8px;object-fit:cover;width:100%">
            </div>
        </div>
        @endif

        @if($barang->dokumen)
        <div class="detail-section mb-3">
            <div class="detail-section-header">
                <i class="bi bi-file-earmark"></i> Dokumen
            </div>
            <div class="detail-section-body">
                <a href="{{ Storage::url($barang->dokumen) }}" target="_blank"
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
                    Barang yang dihapus tidak dapat dikembalikan.
                </p>
                <button type="button"
                        onclick="confirmDelete('{{ route('barang.destroy', $barang) }}', 'Hapus barang {{ addslashes($barang->nama_barang) }}? Tindakan ini tidak dapat dibatalkan.')"
                        style="width:100%;background:#ffebee;border:1px solid #ffcdd2;color:#c62828;border-radius:6px;padding:9px;font-size:13px;cursor:pointer;font-weight:600">
                    <i class="bi bi-trash me-2"></i>Hapus Barang Ini
                </button>
            </div>
        </div>

    </div>
</div>

@endsection
