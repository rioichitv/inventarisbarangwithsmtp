@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')

<div class="page-title">
    <i class="bi bi-box-seam"></i> Data Barang IT
</div>

<div style="margin-bottom:16px">
    <a href="{{ route('barang.create') }}" class="btn btn-primary"
       style="font-size:13px;padding:7px 18px;border-radius:6px">
        <i class="bi bi-plus-lg me-1"></i> Tambah Barang
    </a>
</div>

{{-- Filter --}}
<div class="card-box mb-3">
    <div class="card-box-body" style="padding:14px 18px">
        <form method="GET" action="{{ route('barang.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Cari</label>
                <input type="text" name="search" value="{{ $search }}"
                       class="form-control form-control-sm"
                       placeholder="Kode, nama barang, kategori...">
            </div>
            <div class="col-md-2">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach(['Tersedia','Digunakan','Dipinjam','Rusak'] as $s)
                        <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Kondisi</label>
                <select name="kondisi" class="form-select form-select-sm">
                    <option value="">Semua Kondisi</option>
                    @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                        <option value="{{ $k }}" {{ $kondisi == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
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
                    <th>Foto</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Lokasi</th>
                    <th>Waktu Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $i => $b)
                <tr>
                    <td>{{ $barangs->firstItem() + $i }}</td>
                    <td>
                        @if($b->foto)
                            <img src="{{ Storage::url($b->foto) }}" alt="foto"
                                 style="width:40px;height:40px;object-fit:cover;border-radius:6px;cursor:pointer"
                                 onclick="showImg('{{ Storage::url($b->foto) }}')">
                        @else
                            <div style="width:40px;height:40px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center">
                                <i class="bi bi-image" style="color:#ccc;font-size:16px"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600;color:#3b2db5">{{ $b->kode_barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td style="color:#555">{{ $b->kategori ?? '—' }}</td>
                    <td style="font-weight:600;color:#222">{{ $b->jumlah_barang }}</td>
                    <td>
                        @php $kc=['Baik'=>'badge-baik','Rusak Ringan'=>'badge-ringan','Rusak Berat'=>'badge-berat']; @endphp
                        <span class="{{ $kc[$b->kondisi] ?? '' }}">{{ $b->kondisi }}</span>
                    </td>
                    <td>
                        @php $sc=['Tersedia'=>'badge-tersedia','Digunakan'=>'badge-digunakan','Dipinjam'=>'badge-dipinjam','Rusak'=>'badge-rusak']; @endphp
                        <span class="{{ $sc[$b->status] ?? '' }}">{{ $b->status }}</span>
                    </td>
                    <td style="color:#777">{{ $b->lokasi ?? '—' }}</td>
                    <td style="color:#777;white-space:nowrap;font-size:12px">
                        {{ $b->waktu_input ? $b->waktu_input->format('d/m/Y H:i') : '—' }}
                    </td>
                    <td>
                        <a href="{{ route('barang.show', $b) }}"
                           style="color:#5c6bc0;font-size:15px;margin-right:5px" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('barang.edit', $b) }}"
                           style="color:#FF9800;font-size:15px;margin-right:5px" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form id="del-{{ $b->id }}" method="POST" action="{{ route('barang.destroy', $b) }}" style="display:none">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button" onclick="confirmDelete('{{ route('barang.destroy', $b) }}', 'Hapus barang {{ addslashes($b->nama_barang) }}?')"
                                style="background:none;border:none;color:#f44336;font-size:15px;cursor:pointer;padding:0">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" style="text-align:center;padding:50px;color:#aaa">
                        <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px"></i>
                        Belum ada data barang
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($barangs->hasPages())
        <div class="dt-footer mt-3">
            <div>Menampilkan {{ $barangs->firstItem() }} sampai {{ $barangs->lastItem() }} dari {{ $barangs->total() }} data</div>
            <div class="dt-pagination">
                @if($barangs->onFirstPage())
                    <span class="pg-btn disabled"><i class="bi bi-chevron-left"></i></span>
                @else
                    <a href="{{ $barangs->previousPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-left"></i></a>
                @endif
                @php $start=max(1,$barangs->currentPage()-2); $end=min($barangs->lastPage(),$barangs->currentPage()+2); @endphp
                @for($p=$start;$p<=$end;$p++)
                    <a href="{{ $barangs->url($p) }}" class="pg-btn {{ $p==$barangs->currentPage()?'active':'' }}">{{ $p }}</a>
                @endfor
                @if($barangs->hasMorePages())
                    <a href="{{ $barangs->nextPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-right"></i></a>
                @else
                    <span class="pg-btn disabled"><i class="bi bi-chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

{{-- Modal preview foto --}}
<div id="imgModal" onclick="this.style.display='none'"
     style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.7);z-index:9999;align-items:center;justify-content:center">
    <img id="imgModalSrc" src="" alt="preview"
         style="max-width:90%;max-height:90%;border-radius:10px;box-shadow:0 8px 32px rgba(0,0,0,.5)">
</div>

@push('scripts')
<script>
function showImg(url) {
    document.getElementById('imgModalSrc').src = url;
    const m = document.getElementById('imgModal');
    m.style.display = 'flex';
}
</script>
@endpush
