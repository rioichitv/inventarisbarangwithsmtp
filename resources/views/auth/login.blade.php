<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Inventaris IT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 32px rgba(0,0,0,.10);
            padding: 40px 44px;
            width: 100%;
            max-width: 440px;
        }

        .login-card h4 {
            font-weight: 700;
            font-size: 22px;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .login-card .sub {
            font-size: 13px;
            color: #888;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #444;
            margin-bottom: 5px;
        }

        .input-group-text {
            background: #f8f9fa;
            border-right: none;
            color: #aaa;
        }

        .form-control {
            font-size: 13px;
            border-left: none;
            border-color: #e0e0e0;
            border-radius: 0;
        }

        /* Bungkus seluruh input-group dalam satu border */
        .input-group {
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-group:focus-within {
            border-color: #3b2db5;
            box-shadow: 0 0 0 3px rgba(59,45,181,.1);
        }
        .input-group .input-group-text {
            border: none;
            background: #f8f9fa;
            color: #aaa;
        }
        .input-group .form-control {
            border: none;
            background: #fff;
            box-shadow: none;
            font-size: 13px;
        }
        .input-group .form-control:focus {
            box-shadow: none;
            border: none;
            outline: none;
        }
        .input-group button.input-group-text {
            border: none;
            background: #fff;
        }

        /* Override browser autofill background */
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 40px #fff inset !important;
            -webkit-text-fill-color: #333 !important;
            transition: background-color 9999s ease-in-out 0s;
        }

        .btn-login {
            background: #3b2db5;
            border: none;
            color: #fff;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-login:hover { background: #2e22a0; }

        .demo-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 12px;
            color: #666;
            margin-top: 16px;
        }
        .demo-box p { margin: 0; line-height: 1.8; }

        .footer-text {
            font-size: 12px;
            color: #bbb;
            margin-top: 24px;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px">
        <div style="width:42px;height:42px;background:#3b2db5;border-radius:10px;display:flex;align-items:center;justify-content:center">
            <i class="bi bi-grid-1x2-fill" style="color:#fff;font-size:18px"></i>
        </div>
        <div>
            <div style="font-weight:700;font-size:16px;color:#1a1a2e">Inventaris IT</div>
            <div style="font-size:11px;color:#aaa">Sistem Manajemen Aset</div>
        </div>
    </div>

    <h4>Selamat Datang</h4>
    <p class="sub">Masuk ke sistem inventaris IT Anda</p>

    {{-- Error --}}
    @if($errors->any())
    <div style="background:#ffebee;border-radius:8px;padding:10px 14px;font-size:13px;color:#c62828;margin-bottom:16px;display:flex;align-items:center;gap:8px">
        <i class="bi bi-exclamation-triangle-fill"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope" style="font-size:13px"></i>
                </span>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="form-control"
                       placeholder="email@contoh.com" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock" style="font-size:13px"></i>
                </span>
                <input type="password" name="password" id="pwdField"
                       class="form-control"
                       placeholder="••••••••" required>
                <button type="button" class="input-group-text"
                        onclick="togglePwd()" style="cursor:pointer">
                    <i class="bi bi-eye" id="pwdIcon" style="font-size:13px;color:#aaa"></i>
                </button>
            </div>
        </div>

        <div class="mb-4 d-flex align-items-center gap-2">
            <input type="checkbox" name="remember" id="remember"
                   class="form-check-input" style="margin:0">
            <label for="remember" style="font-size:13px;color:#666;cursor:pointer">Ingat saya</label>
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right"></i> Masuk
        </button>
    </form>


<p class="footer-text">© {{ date('Y') }} Sistem Inventaris IT @ Rio Pratama Putra</p>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd() {
    const f = document.getElementById('pwdField');
    const i = document.getElementById('pwdIcon');
    if (f.type === 'password') { f.type = 'text';     i.className = 'bi bi-eye-slash'; }
    else                       { f.type = 'password'; i.className = 'bi bi-eye'; }
    i.style.fontSize = '13px';
    i.style.color = '#aaa';
}
</script>
</body>
</html>
