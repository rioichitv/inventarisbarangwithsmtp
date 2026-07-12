@extends('layouts.app')

@section('title', 'Log Aktivitas Admin')

@section('content')

<div class="page-title">
    <i class="bi bi-shield-check"></i> Log Aktivitas Admin
</div>

{{-- Filter --}}
<div class="card-box mb-3">
    <div class="card-box-body" style="padding:14px 18px">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Cari</label>
                <input type="text" name="search" value="{{ $search }}"
                       class="form-control form-control-sm"
                       placeholder="Email, username, IP...">
            </div>
            <div class="col-md-2">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="Success"  {{ $status=='Success'  ? 'selected':'' }}>Success</option>
                    <option value="Gagal"    {{ $status=='Gagal'    ? 'selected':'' }}>Gagal</option>
                </select>
            </div>
            <div class="col-md-2">
                <label style="font-size:11px;color:#888;display:block;margin-bottom:4px">Level</label>
                <select name="level" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="Low"      {{ $level=='Low'      ? 'selected':'' }}>Low</option>
                    <option value="Medium"   {{ $level=='Medium'   ? 'selected':'' }}>Medium</option>
                    <option value="Berisiko" {{ $level=='Berisiko' ? 'selected':'' }}>Berisiko</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('activity-log.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
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
                    <th>Username</th>
                    <th>Email</th>
                    <th>IP Address</th>
                    <th>Activity Type</th>
                    <th>Status</th>
                    <th>Level</th>
                    <th>Device</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $i => $log)
                <tr>
                    <td>{{ $logs->firstItem() + $i }}</td>
                    <td style="font-weight:600;color:#3b2db5">{{ $log->username ?? '—' }}</td>
                    <td style="font-size:12px">{{ $log->email ?? '—' }}</td>
                    <td>
                        <code style="font-size:12px;background:#f0f0f0;padding:2px 6px;border-radius:4px">
                            {{ $log->ip_address ?? '—' }}
                        </code>
                    </td>
                    <td style="font-size:12px">{{ $log->activity_type }}</td>
                    <td>
                        @if($log->status === 'Success')
                            <span style="color:#16a34a;font-weight:600;font-size:12px">
                                <i class="bi bi-check-circle-fill me-1"></i>Success
                            </span>
                        @else
                            <span style="color:#dc2626;font-weight:600;font-size:12px">
                                <i class="bi bi-x-circle-fill me-1"></i>Gagal
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($log->level === 'Low')
                            <span style="color:#16a34a;font-weight:600;font-size:12px">Low</span>
                        @elseif($log->level === 'Medium')
                            <span style="color:#d97706;font-weight:600;font-size:12px">Medium</span>
                        @else
                            <span style="color:#dc2626;font-weight:600;font-size:12px">Berisiko</span>
                        @endif
                    </td>
                    <td style="font-size:11px;color:#777;max-width:200px;word-break:break-word">
                        {{ $log->user_agent ?? '—' }}
                    </td>
                    <td style="font-size:12px;color:#777;white-space:nowrap">
                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:50px;color:#aaa">
                        <i class="bi bi-shield-check" style="font-size:2.5rem;display:block;margin-bottom:10px"></i>
                        Belum ada log aktivitas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
        <div class="dt-footer mt-3">
            <div>Menampilkan {{ $logs->firstItem() }} sampai {{ $logs->lastItem() }} dari {{ $logs->total() }} data</div>
            <div class="dt-pagination">
                @if($logs->onFirstPage())
                    <span class="pg-btn disabled"><i class="bi bi-chevron-left"></i></span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-left"></i></a>
                @endif
                @php $start=max(1,$logs->currentPage()-2); $end=min($logs->lastPage(),$logs->currentPage()+2); @endphp
                @for($p=$start;$p<=$end;$p++)
                    <a href="{{ $logs->url($p) }}" class="pg-btn {{ $p==$logs->currentPage()?'active':'' }}">{{ $p }}</a>
                @endfor
                @if($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="pg-btn"><i class="bi bi-chevron-right"></i></a>
                @else
                    <span class="pg-btn disabled"><i class="bi bi-chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
