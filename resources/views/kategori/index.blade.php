@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="page-title">
    <i class="bi bi-tags"></i> Master Kategori
</div>

<div style="margin-bottom:16px">
    <a href="{{ route('kategori.create') }}" class="btn btn-primary"
       style="font-size:13px;padding:7px 18px;border-radius:6px">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
</div>

{{-- Filter --}}
<div class="card-box mb-3">
    <div class="card-box-body" style="padding:14px 18px">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Cari</label>
                <input type="text" name="search" value="{{ $search }}"
                       class="form-control form-control-sm" placeholder="Cari nama kategori...">
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i>Cari
                </button>
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card-box">
    <div class="card-box-body">
        <table class="inv-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $kat)
                <tr>
                    <td>{{ $kategoris->firstItem() + $i }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div style="width:34px;height:34px;background:#eef0fb;border-radius:8px;
                                        display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="bi bi-tag" style="color:#5c6bc0"></i>
                            </div>
                            <span style="font-weight:600">{{ $kat->nama_kategori }}</span>
                        </div>
                    </td>
                    <td style="color:#777">{{ $kat->deskripsi ?? '—' }}</td>
                    <td>
                        <span style="background:{{ $kat->barang_count > 0 ? '#e8f5e9' : '#f5f5f5' }};
                                     color:{{ $kat->barang_count > 0 ? '#2e7d32' : '#999' }};
                                     border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600">
                            {{ $kat->barang_count }} barang
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('kategori.edit', $kat) }}"
                               style="color:#FF9800;font-size:15px" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button"
                                    onclick="konfirmasiHapus({{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}', {{ $kat->barang_count }})"
                                    style="background:none;border:none;color:#f44336;font-size:15px;
                                           cursor:pointer;padding:0;{{ $kat->barang_count > 0 ? 'opacity:.35;cursor:not-allowed' : '' }}"
                                    title="{{ $kat->barang_count > 0 ? 'Masih ada barang terkait' : 'Hapus' }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:50px;color:#aaa">
                        <i class="bi bi-tags" style="font-size:2.5rem;display:block;margin-bottom:10px"></i>
                        Belum ada kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($kategoris->hasPages())
        <div class="dt-footer mt-3">
            <div>Menampilkan {{ $kategoris->firstItem() }} sampai {{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} data</div>
            <div class="dt-pagination">
                @if($kategoris->onFirstPage())
                    <span class="pg-btn disabled"><i class="bi bi-chevron-left"></i></span>
                @else
                    <a href="{{ $kategoris->previousPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-left"></i></a>
                @endif
                @php $start=max(1,$kategoris->currentPage()-2); $end=min($kategoris->lastPage(),$kategoris->currentPage()+2); @endphp
                @for($p=$start;$p<=$end;$p++)
                    <a href="{{ $kategoris->url($p) }}" class="pg-btn {{ $p==$kategoris->currentPage()?'active':'' }}">{{ $p }}</a>
                @endfor
                @if($kategoris->hasMorePages())
                    <a href="{{ $kategoris->nextPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-right"></i></a>
                @else
                    <span class="pg-btn disabled"><i class="bi bi-chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function konfirmasiHapus(id, nama, jumlah) {
    if (jumlah > 0) {
        // Pakai toast global untuk error
        showToast('Kategori "' + nama + '" tidak bisa dihapus karena masih ada ' + jumlah + ' barang.', 'error');
        return;
    }
    // Pakai modal hapus global
    confirmDelete('/kategori/' + id, 'Hapus kategori "' + nama + '"? Tindakan ini tidak bisa dibatalkan.');
}
</script>
@endpush
