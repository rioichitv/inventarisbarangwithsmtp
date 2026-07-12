@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')

<div class="page-title">
    <i class="bi bi-box-arrow-up"></i> Data Barang Keluar
</div>

<div style="margin-bottom:16px">
    <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary"
       style="font-size:13px;padding:7px 18px;border-radius:6px">
        <i class="bi bi-plus-lg me-1"></i> Tambah Barang Keluar
    </a>
</div>

{{-- Filter --}}
<div class="card-box mb-3">
    <div class="card-box-body" style="padding:14px 18px">
        <form method="GET" action="{{ route('barang-keluar.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Cari</label>
                <input type="text" name="search" value="{{ $search }}"
                       class="form-control form-control-sm"
                       placeholder="No keluar, nama barang, penerima...">
            </div>
            <div class="col-md-3">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                       class="form-control form-control-sm">
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
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
                    <th>No. Keluar</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Penerima</th>
                    <th>Bagian</th>
                    <th>Tanggal</th>
                    <th>Keperluan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $k)
                <tr>
                    <td>{{ $data->firstItem() + $i }}</td>
                    <td>
                        @if($k->foto)
                            <img src="{{ Storage::url($k->foto) }}" alt="foto"
                                 style="width:40px;height:40px;object-fit:cover;border-radius:6px;cursor:pointer"
                                 onclick="showImg('{{ Storage::url($k->foto) }}')">
                        @else
                            <div style="width:40px;height:40px;background:#f0f0f0;border-radius:6px;
                                        display:flex;align-items:center;justify-content:center">
                                <i class="bi bi-image" style="color:#ccc;font-size:16px"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600;color:#3b2db5">{{ $k->no_keluar }}</td>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $k->barang->nama_barang ?? '—' }}</div>
                        <small style="color:#aaa">{{ $k->barang->kode_barang ?? '' }}</small>
                    </td>
                    <td style="font-weight:600;color:#222">{{ $k->jumlah }}</td>
                    <td style="color:#444">{{ $k->penerima }}</td>
                    <td style="color:#777">{{ $k->bagian ?? '—' }}</td>
                    <td style="color:#777;white-space:nowrap;font-size:12px">
                        {{ $k->tanggal_keluar->format('d/m/Y') }}
                    </td>
                    <td style="color:#777">{{ $k->keperluan ?? '—' }}</td>
                    <td>
                        <a href="{{ route('barang-keluar.show', $k) }}"
                           style="color:#5c6bc0;font-size:15px;margin-right:5px" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button"
                                onclick="confirmDelete('{{ route('barang-keluar.destroy', $k) }}', 'Hapus data {{ addslashes($k->no_keluar) }}? Stok barang akan dikembalikan.')"
                                style="background:none;border:none;color:#f44336;font-size:15px;cursor:pointer;padding:0"
                                title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:50px;color:#aaa">
                        <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px"></i>
                        Belum ada data barang keluar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($data->hasPages())
        <div class="dt-footer mt-3">
            <div>Menampilkan {{ $data->firstItem() }} sampai {{ $data->lastItem() }} dari {{ $data->total() }} data</div>
            <div class="dt-pagination">
                @if($data->onFirstPage())
                    <span class="pg-btn disabled"><i class="bi bi-chevron-left"></i></span>
                @else
                    <a href="{{ $data->previousPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-left"></i></a>
                @endif
                @php $start=max(1,$data->currentPage()-2); $end=min($data->lastPage(),$data->currentPage()+2); @endphp
                @for($p=$start;$p<=$end;$p++)
                    <a href="{{ $data->url($p) }}" class="pg-btn {{ $p==$data->currentPage()?'active':'' }}">{{ $p }}</a>
                @endfor
                @if($data->hasMorePages())
                    <a href="{{ $data->nextPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-right"></i></a>
                @else
                    <span class="pg-btn disabled"><i class="bi bi-chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal preview foto --}}
<div id="imgModal" onclick="this.style.display='none'"
     style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,.75);z-index:9999;align-items:center;justify-content:center">
    <img id="imgModalSrc" src="" alt="preview"
         style="max-width:90%;max-height:90%;border-radius:10px;box-shadow:0 8px 32px rgba(0,0,0,.5)">
</div>

@endsection

@push('scripts')
<script>
function showImg(url) {
    document.getElementById('imgModalSrc').src = url;
    document.getElementById('imgModal').style.display = 'flex';
}
</script>
@endpush
