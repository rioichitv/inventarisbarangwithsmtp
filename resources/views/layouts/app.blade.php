<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris IT')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.min.css">

    <style>
        :root { --sw: 220px; }
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; font-size: 14px; margin: 0; }

        /* ── SIDEBAR ── */
        #sidebar {
            width: var(--sw);
            min-height: 100vh;
            background: #fff;
            position: fixed;
            top: 0; left: 0; z-index: 1001;
            overflow-y: auto;
            display: flex; flex-direction: column;
            transition: transform .3s;
            box-shadow: 2px 0 8px rgba(0,0,0,.06);
        }
        .sb-brand {
            background: #fff;
            height: 60px;
            display: flex; align-items: center; gap: 10px;
            padding: 0 18px;
            color: #3b2db5;
            font-weight: 700; font-size: 15px; flex-shrink: 0;
            border-bottom: 2px solid #f0f0f0;
        }
        .sb-brand i { font-size: 20px; color: #3b2db5; }
        .sb-user {
            padding: 12px 16px;
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .sb-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: #eef0fb;
            display: flex; align-items: center; justify-content: center;
            color: #5c6bc0; font-size: 17px; flex-shrink: 0;
        }
        .sb-uname { font-size: 13px; font-weight: 600; color: #333; line-height: 1.2; }
        .sb-role  { font-size: 11px; color: #999; }
        .sb-label {
            font-size: 10px; font-weight: 700; letter-spacing: .1em;
            color: #bbb; text-transform: uppercase;
            padding: 14px 18px 4px; display: block;
        }
        .sb-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 18px; color: #555; text-decoration: none;
            font-size: 13px; border-left: 3px solid transparent;
            transition: all .15s;
        }
        .sb-link i.icon { font-size: 15px; width: 18px; text-align: center; color: #bbb; }
        .sb-link .arrow { margin-left: auto; font-size: 11px; color: #ccc; }
        .sb-link:hover  { background: #f0f0fa; color: #3b2db5; border-left-color: #3b2db5; }
        .sb-link:hover i.icon { color: #3b2db5; }
        .sb-link.active { background: #eef0fb; color: #3b2db5; font-weight: 600; border-left-color: #3b2db5; }
        .sb-link.active i.icon { color: #3b2db5; }
        .sb-logout {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 18px; width: 100%;
            background: none; border: none; border-left: 3px solid transparent;
            color: #e53935; font-size: 13px; cursor: pointer; text-align: left;
            transition: all .15s;
        }
        .sb-logout i { font-size: 15px; width: 18px; text-align: center; }
        .sb-logout:hover { background: #fff5f5; border-left-color: #e53935; }

        /* ── TOPBAR ── */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sw);
            right: 0;
            height: 60px;
            background: linear-gradient(135deg, #3b2db5 0%, #5c6bc0 100%);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            z-index: 998;
            box-shadow: 0 2px 8px rgba(59,45,181,.3);
        }
        .tb-toggle {
            background: none; border: none;
            color: rgba(255,255,255,.85); font-size: 22px;
            cursor: pointer; padding: 4px 6px; border-radius: 6px; line-height: 1;
        }
        .tb-toggle:hover { background: rgba(255,255,255,.15); }
        .tb-right { display: flex; align-items: center; gap: 10px; }
        .tb-name  { color: rgba(255,255,255,.9); font-size: 13px; }
        .tb-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(255,255,255,.25);
            border: 2px solid rgba(255,255,255,.4);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 17px;
        }
        .tb-logout-btn {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.3);
            color: #fff; border-radius: 6px; padding: 5px 14px;
            font-size: 12px; cursor: pointer; transition: background .15s;
        }
        .tb-logout-btn:hover { background: rgba(255,255,255,.25); }

        /* ── MAIN ── */
        #main-content {
            margin-left: var(--sw);
            margin-top: 60px;
            padding: 24px;
            min-height: calc(100vh - 60px);
        }
        .page-title {
            font-size: 18px; font-weight: 700; color: #2d2d2d;
            display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
        }
        .page-title i { color: #5c6bc0; }

        /* ── WIDGET CARDS ── */
        .w-card {
            border-radius: 14px;
            padding: 18px 20px;
            display: flex; align-items: center; gap: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: transform .2s, box-shadow .2s;
            height: 100%;
            border: none;
        }
        .w-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.11); }
        .w-icon {
            width: 54px; height: 54px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; flex-shrink: 0; color: #fff;
        }
        .w-num { font-size: 26px; font-weight: 700; color: #222; line-height: 1; margin-bottom: 4px; }
        .w-lbl { font-size: 12px; color: #666; }

        /* ── CARD BOX ── */
        .card-box {
            background: #fff; border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            overflow: hidden; margin-bottom: 20px;
        }
        .card-box-header {
            padding: 14px 18px; border-bottom: 1px solid #f0f0f0;
            font-weight: 600; font-size: 14px; color: #333;
            display: flex; align-items: center; gap: 8px; background: #fafafa;
        }
        .card-box-body { padding: 18px; }

        .alert-info-custom {
            background: #eef0fb; border-radius: 8px; color: #3b2db5;
            padding: 10px 14px; font-size: 13px;
            display: flex; align-items: center; gap: 8px; margin-bottom: 16px;
        }

        /* ── DT CONTROLS ── */
        .dt-controls {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 12px; flex-wrap: wrap; gap: 8px;
        }
        .dt-show { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #555; }
        .dt-show select { border: 1px solid #ddd; border-radius: 4px; padding: 3px 6px; font-size: 13px; }
        .dt-search { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #555; }
        .dt-search input {
            border: 1px solid #ddd; border-radius: 4px;
            padding: 4px 10px; font-size: 13px; outline: none;
        }
        .dt-search input:focus { border-color: #5c6bc0; }

        /* ── TABLE ── */
        .inv-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .inv-table thead th {
            background: #fafafa; color: #555; font-weight: 600;
            padding: 10px 12px; border-bottom: 2px solid #eee; white-space: nowrap;
        }
        .inv-table thead th .sort-icon { color: #ccc; font-size: 11px; margin-left: 3px; }
        .inv-table tbody td {
            padding: 10px 12px; border-bottom: 1px solid #f5f5f5;
            color: #444; vertical-align: middle;
        }
        .inv-table tbody tr:last-child td { border-bottom: none; }
        .inv-table tbody tr:hover td { background: #fafbff; }

        /* ── QTY BADGE ── */
        .qty-badge {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 26px; height: 26px; border-radius: 50%;
            font-size: 12px; font-weight: 700; padding: 0 6px;
        }
        .qty-badge.orange { background: #FF9800; color: #fff; }
        .qty-badge.green  { background: #4CAF50; color: #fff; }
        .qty-badge.blue   { background: #2196F3; color: #fff; }
        .qty-badge.red    { background: #f44336; color: #fff; }

        /* ── PAGINATION ── */
        .dt-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 2px; font-size: 13px; color: #666; flex-wrap: wrap; gap: 8px;
        }
        .dt-pagination { display: flex; align-items: center; gap: 4px; }
        .pg-btn {
            min-width: 30px; height: 30px; border-radius: 50%;
            border: 1px solid #e0e0e0; background: #fff; color: #555;
            font-size: 13px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all .15s; padding: 0 8px; text-decoration: none;
        }
        .pg-btn:hover  { background: #eef0fb; border-color: #5c6bc0; color: #3b2db5; }
        .pg-btn.active { background: #3b2db5; border-color: #3b2db5; color: #fff; }
        .pg-btn.disabled { opacity: .4; cursor: default; pointer-events: none; }

        /* ── STATUS BADGES ── */
        .badge-baik      { background: #e8f5e9; color: #2e7d32; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; }
        .badge-ringan    { background: #fff8e1; color: #f57f17; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; }
        .badge-berat     { background: #ffebee; color: #c62828; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; }
        .badge-tersedia  { background: #e3f2fd; color: #1565c0; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; }
        .badge-digunakan { background: #ede7f6; color: #4527a0; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; }
        .badge-dipinjam  { background: #fff3e0; color: #e65100; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; }
        .badge-rusak     { background: #ffebee; color: #c62828; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; }

        /* ── FORM STYLES ── */
        .form-control, .form-select { font-size: 13px; border-color: #e0e0e0; border-radius: 6px; }
        .form-control:focus, .form-select:focus { border-color: #5c6bc0; box-shadow: 0 0 0 3px rgba(92,107,192,.12); }
        .btn-primary { background: #3b2db5; border-color: #3b2db5; }
        .btn-primary:hover, .btn-primary:active { background: #2e22a0 !important; border-color: #2e22a0 !important; }
        .btn-outline-primary { color: #3b2db5; border-color: #3b2db5; }
        .btn-outline-primary:hover { background: #3b2db5; color: #fff; }

        .form-section { background: #fff; border-radius: 10px; box-shadow: 0 1px 8px rgba(0,0,0,.07); margin-bottom: 18px; overflow: hidden; }
        .form-section-header { padding: 12px 18px; border-bottom: 1px solid #f0f0f0; font-weight: 600; font-size: 13px; color: #3b2db5; display: flex; align-items: center; gap: 7px; background: #fafbff; }
        .form-section-body { padding: 18px; }
        .form-label { font-size: 12px; font-weight: 600; color: #555; margin-bottom: 5px; }
        .required { color: #f44336; }
        .field-hint { font-size: 11px; color: #aaa; margin-top: 3px; }

        .foto-drop { border: 2px dashed #d0d4f0; border-radius: 8px; padding: 20px; text-align: center; cursor: pointer; transition: all .2s; background: #fafbff; }
        .foto-drop:hover { border-color: #5c6bc0; background: #eef0fb; }
        .foto-drop i { font-size: 28px; color: #c5cae9; }
        .foto-drop p { font-size: 12px; color: #aaa; margin: 6px 0 0; }

        .btn-save { background: #3b2db5; color: #fff; border: none; border-radius: 6px; padding: 9px 28px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background .2s; }
        .btn-save:hover { background: #2e22a0; }
        .btn-cancel { background: #fff; color: #666; border: 1px solid #ddd; border-radius: 6px; padding: 9px 20px; font-size: 13px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-cancel:hover { background: #f5f5f5; color: #333; }

        .detail-section { background: #fff; border-radius: 10px; box-shadow: 0 1px 8px rgba(0,0,0,.07); margin-bottom: 18px; overflow: hidden; }
        .detail-section-header { padding: 12px 18px; border-bottom: 1px solid #f0f0f0; font-weight: 600; font-size: 13px; color: #3b2db5; display: flex; align-items: center; gap: 7px; background: #fafbff; }
        .detail-section-body { padding: 18px; }
        .detail-item { width: 50%; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
        .detail-item .d-label { font-size: 11px; color: #aaa; margin-bottom: 2px; }
        .detail-item .d-value { font-size: 13px; color: #333; font-weight: 500; }

        /* ── FOOTER ── */
        .main-footer { text-align: center; padding: 14px; font-size: 12px; color: #aaa; margin-left: var(--sw); }
        .main-footer a { color: #5c6bc0; text-decoration: none; }

        /* ── jQuery UI ── */
        .ui-autocomplete { z-index: 9999 !important; border-radius: 6px; box-shadow: 0 4px 16px rgba(0,0,0,.12); font-size: 13px; }
        .ui-menu-item-wrapper { padding: 7px 12px !important; }
        .ui-state-active, .ui-widget-content .ui-state-active { background: #eef0fb !important; color: #3b2db5 !important; border-color: #eef0fb !important; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #topbar { left: 0; }
            #main-content, .main-footer { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ══ SIDEBAR ══ --}}
<nav id="sidebar">
    <div class="sb-brand">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Inventaris IT</span>
    </div>

    <ul class="list-unstyled mb-0 mt-1 pb-4">
        <li><span class="sb-label">Master</span></li>
        <li>
            <a href="{{ route('dashboard') }}"
               class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 icon"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('barang.index') }}"
               class="sb-link {{ request()->routeIs('barang.index','barang.show','barang.create','barang.edit') ? 'active' : '' }}">
                <i class="bi bi-box-seam icon"></i>
                <span>Input Barang</span>
            </a>
        </li>
        <li>
            <a href="{{ route('barang-keluar.index') }}"
               class="sb-link {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up icon"></i>
                <span>Barang Keluar</span>
            </a>
        </li>

        <li><span class="sb-label">Pengaturan</span></li>
        <li>
            <a href="{{ route('settings.web-config') }}"
               class="sb-link {{ request()->routeIs('settings.web-config') ? 'active' : '' }}">
                <i class="bi bi-option"></i>
                <span>Web Config</span>
            </a>
        </li>
        <li>
            <a href="{{ route('activity-log.index') }}"
               class="sb-link {{ request()->routeIs('activity-log.*') ? 'active' : '' }}">
                <i class="bi bi-shield-check icon"></i>
                <span>Log Aktivitas Admin</span>
            </a>
        </li>

        <li><span class="sb-label">Bantuan</span></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>
    </ul>
</nav>

{{-- ══ TOPBAR ══ --}}
<div id="topbar">
    <button class="tb-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <div class="tb-right">
        <span class="tb-name d-none d-sm-inline">{{ Auth::user()->name }}</span>
        <div class="tb-avatar"><i class="bi bi-person-fill"></i></div>
    </div>
</div>

{{-- ══ MAIN ══ --}}
<div id="main-content">
    @yield('content')
</div>

<div class="main-footer">
    Copyright © {{ date('Y') }} <a href="#">Rio Pratama Putra</a>
</div>


{{-- ══ TOAST NOTIFICATION (bawah kanan) ══ --}}
<div id="toastBox"
     style="position:fixed;bottom:30px;right:30px;z-index:9999;display:none;
            min-width:300px;max-width:380px;
            border-radius:14px;padding:18px 22px;
            box-shadow:0 8px 30px rgba(0,0,0,.18);
            display:none;align-items:center;gap:14px">
    <div id="toastIcon"
         style="width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
        <i id="toastIconI" style="font-size:20px"></i>
    </div>
    <div style="flex:1">
        <div id="toastTitle" style="font-weight:700;font-size:14px;margin-bottom:2px"></div>
        <div id="toastMsg"   style="font-size:13px;opacity:.85"></div>
    </div>
    <button onclick="document.getElementById('toastBox').style.display='none'"
            style="background:none;border:none;cursor:pointer;opacity:.5;font-size:18px;padding:0;line-height:1">
        &times;
    </button>
</div>

{{-- ══ MODAL KONFIRMASI HAPUS GLOBAL ══ --}}
<div id="deleteModal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9000;
            align-items:center;justify-content:center">
    <div style="background:#fff;border-radius:14px;width:100%;max-width:400px;
                margin:16px;overflow:hidden;box-shadow:rgba(0,0,0,.18) 0px 8px 40px;
                animation:popIn .25s ease">

        {{-- Body --}}
        <div style="padding:28px 24px 20px;text-align:center">
            <div style="width:56px;height:56px;border-radius:50%;background:#fce4e4;
                        display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                <svg width="26" height="26" fill="none" stroke="#ea5455" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6l-1 14H6L5 6"></path>
                    <path d="M10 11v6M14 11v6"></path>
                    <path d="M9 6V4h6v2"></path>
                </svg>
            </div>
            <div style="font-size:17px;font-weight:700;color:#566a7f;margin-bottom:10px">
                Apakah Yakin Ingin Dihapus?
            </div>
            <div id="deleteDesc" style="font-size:13px;color:#8592a3;line-height:1.6"></div>
        </div>

        {{-- Footer --}}
        <div style="display:flex;gap:12px;padding:16px 24px;border-top:1px solid #f0f0f0">
            <button onclick="closeDeleteModal()"
                    onmouseover="this.style.background='#e0e0e0'"
                    onmouseout="this.style.background='#f0f0f0'"
                    style="flex:1;background:#f0f0f0;color:#566a7f;border:none;
                           border-radius:8px;padding:10px;font-size:14px;
                           font-weight:600;cursor:pointer;transition:background .15s">
                Batal
            </button>
            <form id="deleteForm" method="POST" style="flex:1;margin:0">
                @csrf @method('DELETE')
                <button type="submit"
                        onmouseover="this.style.background='#d93636'"
                        onmouseout="this.style.background='#ea5455'"
                        style="width:100%;background:#ea5455;color:#fff;border:none;
                               border-radius:8px;padding:10px;font-size:14px;
                               font-weight:600;cursor:pointer;transition:background .15s">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes popIn {
    from { transform:scale(.85);opacity:0; }
    to   { transform:scale(1);opacity:1; }
}
@keyframes slideUp {
    from { transform:translateY(20px);opacity:0; }
    to   { transform:translateY(0);opacity:1; }
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('show');
    });

    // ── TOAST ──
    function showToast(msg, type) {
        const box   = document.getElementById('toastBox');
        const icon  = document.getElementById('toastIconI');
        const title = document.getElementById('toastTitle');
        const text  = document.getElementById('toastMsg');

        if (type === 'error') {
            box.style.background   = '#fff5f5';
            box.style.border       = '1.5px solid #ffcdd2';
            document.getElementById('toastIcon').style.background = '#ffebee';
            icon.className  = 'bi bi-x-circle-fill';
            icon.style.color = '#e53935';
            title.style.color = '#c62828';
            title.textContent = 'Gagal!';
        } else {
            box.style.background   = '#f0fdf4';
            box.style.border       = '1.5px solid #a7f3d0';
            document.getElementById('toastIcon').style.background = '#dcfce7';
            icon.className  = 'bi bi-check-circle-fill';
            icon.style.color = '#16a34a';
            title.style.color = '#166534';
            title.textContent = 'Berhasil!';
        }

        text.textContent = msg;
        box.style.display = 'flex';
        box.style.animation = 'slideUp .3s ease';

        clearTimeout(window._toastTimer);
        window._toastTimer = setTimeout(() => {
            box.style.display = 'none';
        }, 4000);
    }

    // ── MODAL HAPUS ──
    function confirmDelete(action, desc) {
        desc = desc || 'Data yang dihapus tidak dapat dikembalikan.';
        document.getElementById('deleteDesc').textContent = desc;
        document.getElementById('deleteForm').action = action;
        const m = document.getElementById('deleteModal');
        m.style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Klik luar modal → tutup
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Auto tampilkan toast dari session Laravel
    @if(session('success'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('success') }}", 'success');
        });
    @endif
    @if(session('error'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('error') }}", 'error');
        });
    @endif
</script>
@stack('scripts')
</body>
</html>
