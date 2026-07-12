<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Data Inventaris Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --gold: #c9a84c;
            --gold-light: #f0d080;
            --dark: #1a2744;
            --dark2: #243057;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f6fa; color: #333; }

        /* ── NAVBAR ── */
        .navbar-top {
            background: transparent;
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            transition: background .3s ease, box-shadow .3s ease;
        }
        .navbar-top.scrolled {
            background: var(--dark);
            box-shadow: 0 2px 16px rgba(0,0,0,.3);
        }
        .navbar-top .brand {
            display: flex; align-items: center; gap: 14px; padding: 12px 24px;
        }
        .navbar-top .brand .logo-circle {
            width: 46px; height: 46px; background: var(--gold); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: var(--dark); font-weight: 900; flex-shrink: 0;
        }
        .navbar-top .brand .site-name { font-size: 15px; font-weight: 700; color: #fff; line-height: 1.2; }
        .navbar-top .brand .site-sub  { font-size: 11px; color: var(--gold-light); opacity: .85; }
        .navbar-top .nav-links { display: flex; align-items: center; gap: 4px; padding: 0 16px; }
        .navbar-top .nav-links a {
            color: rgba(255,255,255,.8); text-decoration: none;
            padding: 8px 14px; border-radius: 6px; font-size: 13px; transition: all .15s;
        }
        .navbar-top .nav-links a:hover, .navbar-top .nav-links a.active {
            background: rgba(255,255,255,.1); color: var(--gold-light);
        }
        .btn-masuk {
            background: var(--gold) !important; color: var(--dark) !important;
            font-weight: 700 !important; padding: 8px 20px !important; border-radius: 6px;
        }
        .btn-masuk:hover { background: var(--gold-light) !important; }

        /* ── HERO ── */
        .hero {
            position: relative; min-height: 520px;
            padding-top: 70px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark2) 60%, #2d4a8a 100%);
            display: flex; align-items: center; overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: url('https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Australian_House_of_Representatives_-_Parliament_of_Australia.jpg/960px-Australian_House_of_Representatives_-_Parliament_of_Australia.jpg') center/cover no-repeat;
            opacity: .18;
        }
        .hero-content { position: relative; z-index: 2; padding: 60px 48px; max-width: 640px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(201,168,76,.2); border: 1px solid rgba(201,168,76,.4);
            color: var(--gold-light); padding: 5px 14px; border-radius: 20px;
            font-size: 12px; font-weight: 600; margin-bottom: 20px;
        }
        .hero h1 { font-size: 36px; font-weight: 800; color: #fff; line-height: 1.25; margin-bottom: 16px; }
        .hero h1 span { color: var(--gold-light); }
        .hero p { font-size: 15px; color: rgba(255,255,255,.75); line-height: 1.7; margin-bottom: 32px; }
        .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-hero-primary {
            background: var(--gold); color: var(--dark); border: none;
            padding: 12px 28px; border-radius: 8px; font-weight: 700; font-size: 14px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 7px;
            transition: background .2s;
        }
        .btn-hero-primary:hover { background: var(--gold-light); color: var(--dark); }
        .btn-hero-outline {
            background: transparent; color: #fff; border: 2px solid rgba(255,255,255,.4);
            padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 7px; transition: all .2s;
        }
        .btn-hero-outline:hover { border-color: var(--gold-light); color: var(--gold-light); }

        /* Hero stats card */
        .hero-stats { position: relative; z-index: 2; margin-left: auto; padding: 40px 48px 40px 0; }
        .stats-card {
            background: rgba(255,255,255,.08); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.15); border-radius: 16px;
            padding: 24px 28px; min-width: 240px;
        }
        .stats-card .stat-item {
            display: flex; align-items: center; gap: 14px;
            padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .stats-card .stat-item:last-child { border-bottom: none; }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: rgba(201,168,76,.2); display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: var(--gold-light); flex-shrink: 0;
        }
        .stat-num { font-size: 22px; font-weight: 800; color: #fff; line-height: 1; }
        .stat-lbl { font-size: 12px; color: rgba(255,255,255,.55); }

        /* ── INFO STRIP ── */
        .info-strip { background: var(--dark); padding: 48px 0; }
        .info-item { text-align: center; }
        .info-item .big-num { font-size: 40px; font-weight: 900; color: var(--gold-light); line-height: 1; margin-bottom: 4px; }
        .info-item .big-lbl { font-size: 13px; color: rgba(255,255,255,.65); }

        /* ── FITUR ── */
        .section { padding: 64px 0; }
        .section-title { text-align: center; margin-bottom: 48px; }
        .section-title .badge-label {
            display: inline-block; background: #eef0fb; color: var(--dark);
            border-radius: 20px; padding: 4px 14px; font-size: 12px; font-weight: 700; margin-bottom: 12px;
        }
        .section-title h2 { font-size: 28px; font-weight: 800; color: var(--dark); margin-bottom: 10px; }
        .section-title p  { font-size: 14px; color: #666; max-width: 520px; margin: 0 auto; }
        .feature-card {
            background: #fff; border-radius: 14px; padding: 28px 24px;
            box-shadow: 0 2px 16px rgba(0,0,0,.06); height: 100%;
            transition: transform .2s, box-shadow .2s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.1); }
        .feature-icon {
            width: 52px; height: 52px; border-radius: 12px; background: #eef0fb;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: var(--dark); margin-bottom: 16px;
        }
        .feature-card h5 { font-size: 15px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
        .feature-card p  { font-size: 13px; color: #777; line-height: 1.6; margin: 0; }

        /* ── CTA ── */
        .cta-section {
            background: linear-gradient(135deg, #1a2744, #2d4a8a);
            padding: 60px 0; text-align: center;
        }
        .cta-section h2 { font-size: 26px; font-weight: 800; color: #fff; margin-bottom: 12px; }
        .cta-section p  { font-size: 14px; color: rgba(255,255,255,.7); margin-bottom: 28px; }

        /* ── FOOTER ── */
        footer { background: #111827; padding: 28px 0; text-align: center; }
        footer p { font-size: 13px; color: rgba(255,255,255,.4); margin: 0; }
        footer span { color: var(--gold); }

        @media (max-width: 768px) {
            .hero-content { padding: 40px 24px; }
            .hero h1 { font-size: 26px; }
            .hero-stats { display: none; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="brand">
            <div class="logo-circle"><i class="bi bi-building-fill-gear"></i></div>
            <div>
                <div class="site-name">INVENTARIS BARANG</div>
                <div class="site-sub">Sistem Data Inventaris Aset</div>
            </div>
        </div>
        <div class="nav-links d-none d-md-flex">
            <a href="{{ route('home') }}" class="active"><i class="bi bi-house me-1"></i>Beranda</a>
            <a href="#fitur"><i class="bi bi-grid me-1"></i>Fitur</a>
            <a href="#tentang"><i class="bi bi-info-circle me-1"></i>Tentang</a>
            <a href="{{ route('login') }}" class="btn-masuk ms-2">
                <i class="bi bi-box-arrow-in-right me-1"></i>Masuk Sistem
            </a>
        </div>
        <a href="{{ route('login') }}" class="btn-masuk d-md-none"
           style="text-decoration:none;font-size:13px">Masuk</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="bi bi-shield-check"></i> Sistem Resmi Inventaris Aset
                </div>
                <h1>Sistem Data <span>Inventaris</span><br>Barang</h1>
                <p>Platform terpadu untuk pengelolaan, pendataan, dan pemantauan seluruh aset dan
                   perangkat IT milik Dewan Perwakilan Rakyat Republik Indonesia.</p>
                <div class="hero-btns">
                    <a href="{{ route('login') }}" class="btn-hero-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                    </a>
                    <a href="#fitur" class="btn-hero-outline">
                        <i class="bi bi-info-circle"></i> Pelajari Fitur
                    </a>
                </div>
            </div>
            <div class="hero-stats">
                <div class="stats-card">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-pc-display"></i></div>
                        <div><div class="stat-num">{{ \App\Models\Barang::count() }}+</div><div class="stat-lbl">Total Aset IT</div></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                        <div><div class="stat-num">{{ \App\Models\Barang::where('status','Tersedia')->count() }}</div><div class="stat-lbl">Aset Tersedia</div></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-tags"></i></div>
                        <div><div class="stat-num">{{ \App\Models\Barang::whereNotNull('kategori')->distinct('kategori')->count() }}</div><div class="stat-lbl">Kategori Barang</div></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-shield-check"></i></div>
                        <div><div class="stat-num">100%</div><div class="stat-lbl">Data Terenkripsi</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INFO STRIP -->
<div class="info-strip">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="info-item">
                    <div class="big-num" data-target="{{ \App\Models\Barang::count() }}">0</div>
                    <div class="big-lbl">Aset Terdaftar</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-item">
                    <div class="big-num" data-target="{{ \App\Models\Barang::whereNotNull('kategori')->distinct('kategori')->count() }}">0</div>
                    <div class="big-lbl">Kategori Barang</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-item">
                    <div class="big-num" data-target="100">0</div>
                    <div class="big-lbl">% Kondisi Baik</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-item">
                    <div class="big-num" data-target="24">0</div>
                    <div class="big-lbl">Jam Monitoring</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FITUR -->
<section class="section" id="fitur">
    <div class="container">
        <div class="section-title">
            <h2>Kelola Inventaris dengan Mudah</h2>
            <p>Sistem terintegrasi untuk pengelolaan aset dan perangkat IT secara efisien dan transparan.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-box-seam"></i></div>
                    <h5>Manajemen Data Barang</h5>
                    <p>Input, edit, dan kelola seluruh data barang IT dengan lengkap termasuk foto dan dokumen pendukung.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-box-arrow-up"></i></div>
                    <h5>Pencatatan Barang Keluar</h5>
                    <p>Catat setiap pengeluaran barang secara detail, stok otomatis diperbarui setiap transaksi.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-speedometer2"></i></div>
                    <h5>Dashboard Statistik</h5>
                    <p>Pantau total aset, kondisi, status pemakaian, dan informasi penting lainnya secara real-time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-shield-lock"></i></div>
                    <h5>Login dengan OTP</h5>
                    <p>Keamanan login dua langkah menggunakan kode OTP yang dikirim ke email administrator.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-clock-history"></i></div>
                    <h5>Log Aktivitas Admin</h5>
                    <p>Rekam semua aktivitas login, logout, dan akses sistem beserta IP address dan device.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-image"></i></div>
                    <h5>Upload Foto & Dokumen</h5>
                    <p>Simpan foto kondisi barang dan dokumen pendukung langsung di dalam sistem inventaris.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section" id="tentang">
    <div class="container">
        <div style="width:64px;height:64px;background:rgba(201,168,76,.2);border-radius:50%;
                    display:flex;align-items:center;justify-content:center;margin:0 auto 20px;
                    font-size:28px;color:var(--gold-light)">
            <i class="bi bi-building-fill-gear"></i>
        </div>
        <h2>Sistem Inventaris Barang</h2>
        <p>Platform pengelolaan aset IT yang aman, transparan, dan mudah digunakan<br>
           untuk mendukung kinerja Dewan Perwakilan Rakyat Republik Indonesia.</p>
        <a href="{{ route('login') }}" class="btn-hero-primary" style="display:inline-flex">
            <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem Inventaris
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p>
        © {{ date('Y') }} <span>By Rio Pratama Putra</span> 
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Navbar scroll effect
window.addEventListener('scroll', function () {
    const nav = document.querySelector('.navbar-top');
    if (window.scrollY > 50) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});

// Counter animasi
function animateCounter(el, target, duration) {
    let start = 0;
    const step = Math.max(1, Math.ceil(target / (duration / 16)));
    const timer = setInterval(() => {
        start += step;
        if (start >= target) { start = target; clearInterval(timer); }
        el.textContent = start;
    }, 16);
}
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.querySelectorAll('[data-target]').forEach(el => {
                animateCounter(el, parseInt(el.dataset.target) || 0, 1200);
            });
            observer.unobserve(e.target);
        }
    });
}, { threshold: .3 });
document.querySelectorAll('.info-strip').forEach(el => observer.observe(el));

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const t = document.querySelector(a.getAttribute('href'));
        if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
    });
});
</script>
</body>
</html>
