@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="page-title">
    <i class="bi bi-house-fill"></i> Dashboard
</div>

{{-- 8 Widget --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-box-seam"></i></div>
            <div>
                <div class="w-num">{{ $totalBarang }}</div>
                <div class="w-lbl">Total Kategori Barang</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-layers"></i></div>
            <div>
                <div class="w-num">{{ $totalJumlah }}</div>
                <div class="w-lbl">Total Jumlah Barang</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="w-num">{{ $tersedia }}</div>
                <div class="w-lbl">Tersedia</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-exclamation-triangle"></i></div>
            <div>
                <div class="w-num">{{ $rusak }}</div>
                <div class="w-lbl">Kondisi Rusak</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-person-check"></i></div>
            <div>
                <div class="w-num">{{ $digunakan }}</div>
                <div class="w-lbl">Sedang Digunakan</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-arrow-left-right"></i></div>
            <div>
                <div class="w-num">{{ $dipinjam }}</div>
                <div class="w-lbl">Dipinjam</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-tags"></i></div>
            <div>
                <div class="w-num">{{ $perKategori->count() }}</div>
                <div class="w-lbl">Jenis Kategori</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="w-card" style="background:#ffffff">
            <div class="w-icon" style="background:#3b2db5"><i class="bi bi-calendar-check"></i></div>
            <div>
                <div class="w-num" style="font-size:15px">{{ now()->format('d/m/Y') }}</div>
                <div class="w-lbl">Tanggal Hari Ini</div>
            </div>
        </div>
    </div>

</div>

<div style="border-radius:14px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.07)">
    <div id="dashCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">

        <div class="carousel-inner">

            {{-- Slide 1 — Ringkasan Barang --}}
            <div class="carousel-item active">
                <div style="background:#3b2db5;
                            padding:32px 48px;display:flex;align-items:center;gap:32px;min-height:130px">
                    <div style="width:58px;height:58px;background:rgba(255,255,255,.15);border-radius:14px;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-box-seam" style="font-size:1.8rem;color:#fff"></i>
                    </div>
                    <div>
                        <div style="font-size:17px;font-weight:700;color:#fff;margin-bottom:5px">
                            Total {{ $totalBarang }} Jenis Barang IT Terdaftar
                        </div>
                        <div style="font-size:13px;color:rgba(255,255,255,.75);display:flex;gap:8px;flex-wrap:wrap">
                            <span style="background:rgba(255,255,255,.15);border-radius:4px;padding:2px 10px">
                                ✓ {{ $tersedia }} Tersedia
                            </span>
                            <span style="background:rgba(255,255,255,.15);border-radius:4px;padding:2px 10px">
                                ↗ {{ $digunakan }} Digunakan
                            </span>
                            <span style="background:rgba(255,255,255,.15);border-radius:4px;padding:2px 10px">
                                ↔ {{ $dipinjam }} Dipinjam
                            </span>
                        </div>
                    </div>
                    <div style="margin-left:auto;text-align:right;flex-shrink:0">
                        <div style="font-size:52px;font-weight:800;color:rgba(255, 255, 255, 0.85);line-height:1">
                            {{ $totalJumlah }}
                        </div>
                        <div style="font-size:12px;color:rgba(255, 255, 255, 0.85);margin-top:2px">Total Unit</div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 — Kondisi Barang --}}
            <div class="carousel-item">
                <div style="background:#3b2db5;
                            padding:32px 48px;display:flex;align-items:center;gap:32px;min-height:130px">
                    <div style="width:58px;height:58px;background:rgba(255,255,255,.15);border-radius:14px;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-shield-check" style="font-size:1.8rem;color:#fff"></i>
                    </div>
                    <div>
                        <div style="font-size:17px;font-weight:700;color:#fff;margin-bottom:5px">
                            Laporan Kondisi Barang
                        </div>
                        <div style="font-size:13px;color:rgba(255, 255, 255, 0.85);display:flex;gap:8px;flex-wrap:wrap">
                            <span style="background:rgba(255, 255, 255, 0);border-radius:4px;padding:2px 10px">
                                ✓ {{ $totalBarang - $rusak }} Kondisi Baik
                            </span>
                            @if($rusak > 0)
                            <span style="background:rgba(255,200,150,.25);border-radius:4px;padding:2px 10px">
                                ⚠ {{ $rusak }} Perlu Perhatian
                            </span>
                            @endif
                        </div>
                    </div>
                    <div style="margin-left:auto;text-align:right;flex-shrink:0">
                        <div style="font-size:52px;font-weight:800;color:rgba(255, 255, 255, 0.85);line-height:1">
                            {{ $totalBarang > 0 ? round(($totalBarang - $rusak) / $totalBarang * 100) : 100 }}%
                        </div>
                        <div style="font-size:12px;color:rgba(255, 255, 255, 0.85);margin-top:2px">Kondisi Baik</div>
                    </div>
                </div>
            </div>

            {{-- Slide 3 — Kategori --}}
            <div class="carousel-item">
                <div style="background:#3b2db5;
                            padding:32px 48px;display:flex;align-items:center;gap:32px;min-height:130px">
                    <div style="width:58px;height:58px;background:rgba(255,255,255,.15);border-radius:14px;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-tags" style="font-size:1.8rem;color:#fff"></i>
                    </div>
                    <div>
                        <div style="font-size:17px;font-weight:700;color:#fff;margin-bottom:5px">
                            {{ $perKategori->count() }} Kategori Barang IT
                        </div>
                        <div style="font-size:13px;color:rgba(255,255,255,.85);display:flex;flex-wrap:wrap;gap:6px">
                            @foreach($perKategori->take(4) as $kat)
                            <span style="background:rgba(255,255,255,.2);border-radius:4px;padding:2px 10px">
                                {{ $kat->kategori }}
                            </span>
                            @endforeach
                            @if($perKategori->count() > 4)
                            <span style="color:rgba(255,255,255,.6);font-size:12px;align-self:center">
                                +{{ $perKategori->count() - 4 }} lainnya
                            </span>
                            @endif
                        </div>
                    </div>
                    <div style="margin-left:auto;text-align:right;flex-shrink:0">
                        <div style="font-size:52px;font-weight:800;color:rgba(255, 255, 255, 0.85);line-height:1">
                            {{ $perKategori->count() }}
                        </div>
                        <div style="font-size:12px;color:rgba(255, 255, 255, 0.85);margin-top:2px">Kategori</div>
                    </div>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#dashCarousel" data-bs-slide="prev"
                style="width:44px">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#dashCarousel" data-bs-slide="next"
                style="width:44px">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

@endsection
