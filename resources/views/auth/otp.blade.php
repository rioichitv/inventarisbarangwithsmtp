<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP — Inventaris IT</title>
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
        .otp-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 32px rgba(0,0,0,.10);
            padding: 40px 44px;
            width: 100%;
            max-width: 440px;
        }

        /* 6 kotak OTP */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0 28px;
        }
        .otp-inputs input {
            width: 48px;
            height: 56px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            color: #1e40af;
            background: #dbeafe;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            caret-color: #3b2db5;
        }
        .otp-inputs input:focus {
            border-color: #3b2db5;
            box-shadow: 0 0 0 3px rgba(59,45,181,.12);
            background: #ede9fe;
        }
        .otp-inputs input.filled {
            border-color: #3b2db5;
            background: #ede9fe;
        }

        /* Hidden real input */
        #otpReal { display: none; }

        .btn-verify {
            background: #3b2db5;
            border: none;
            color: #fff;
            width: 100%;
            padding: 13px;
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
        .btn-verify:hover { background: #2e22a0; }
        .btn-verify:disabled { opacity: .6; cursor: not-allowed; }

        /* Toast notifikasi */
        .toast-notif {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            min-width: 300px;
            max-width: 380px;
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,.18);
            animation: slideUp .3s ease;
            display: none;
        }
        .toast-notif.error {
            background: #fff5f5;
            border: 1.5px solid #ffcdd2;
            color: #c62828;
        }
        .toast-notif.success {
            background: #f0fdf4;
            border: 1.5px solid #a7f3d0;
            color: #166534;
        }
        .toast-notif .t-icon {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 18px;
        }
        .toast-notif.error .t-icon { background: #ffebee; }
        .toast-notif.success .t-icon { background: #dcfce7; }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }

        .footer-text { font-size: 12px; color: #bbb; margin-top: 24px; }
        .timer-text { font-size: 12px; color: #aaa; text-align: center; margin-top: 8px; }
        .timer-count { color: #e53935; font-weight: 700; }
    </style>
</head>
<body>

<div class="otp-card">

    {{-- Logo --}}
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px">
        <div style="width:42px;height:42px;background:#3b2db5;border-radius:10px;
                    display:flex;align-items:center;justify-content:center">
            <i class="bi bi-shield-lock" style="color:#fff;font-size:18px"></i>
        </div>
        <div>
            <div style="font-weight:700;font-size:16px;color:#1a1a2e">Verifikasi OTP</div>
            <div style="font-size:11px;color:#aaa">Keamanan Akun Admin</div>
        </div>
    </div>

    <h4 style="font-weight:700;font-size:20px;color:#1a1a2e;margin-bottom:6px">
        Masukkan Kode OTP
    </h4>
    <p style="font-size:13px;color:#888;margin-bottom:0">
        Kode 6 digit telah dikirim ke email Anda. Berlaku 5 menit.
    </p>

    {{-- Form --}}
    <form method="POST" action="{{ route('login.otp.verify') }}" id="otpForm">
        @csrf
        <input type="hidden" name="otp" id="otpReal">

        {{-- 6 kotak input --}}
        <div class="otp-inputs" id="otpBoxes">
            <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="0">
            <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="1">
            <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="2">
            <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="3">
            <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="4">
            <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="5">
        </div>

        {{-- Timer --}}
        <div class="timer-text" id="timerWrap">
            Kode kadaluarsa dalam <span class="timer-count" id="timerCount">5:00</span>
        </div>

        <button type="submit" class="btn-verify mt-3" id="btnVerify">
            <i class="bi bi-check-lg"></i> Verifikasi & Masuk
        </button>
    </form>

    {{-- Kirim ulang --}}
    <div class="text-center mt-3">
        <form method="POST" action="{{ route('login.otp.resend') }}">
            @csrf
            <span style="font-size:13px;color:#888">Tidak menerima kode? </span>
            <button type="submit"
                    style="background:none;border:none;padding:0;color:#3b2db5;
                           font-size:13px;font-weight:600;text-decoration:underline;cursor:pointer">
                Kirim Ulang OTP
            </button>
        </form>
    </div>

</div>

<p class="footer-text">© {{ date('Y') }} Sistem Inventaris IT</p>

{{-- Toast container --}}
<div class="toast-notif" id="toastNotif">
    <div class="t-icon" id="toastIcon">
        <i id="toastIconI"></i>
    </div>
    <div>
        <div id="toastTitle" style="margin-bottom:2px"></div>
        <div id="toastMsg" style="font-weight:400;font-size:13px"></div>
    </div>
    <button onclick="this.parentElement.style.display='none'"
            style="margin-left:auto;background:none;border:none;cursor:pointer;
                   font-size:18px;opacity:.5;line-height:1">&times;</button>
</div>

<script>
// ── OTP INPUT BEHAVIOUR ──
const digits  = document.querySelectorAll('.otp-digit');
const realInp = document.getElementById('otpReal');
const btnVerify = document.getElementById('btnVerify');

digits.forEach((inp, idx) => {
    inp.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(-1);
        if (this.value && idx < 5) digits[idx + 1].focus();
        syncOtp();
        this.classList.toggle('filled', !!this.value);
    });

    inp.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && !this.value && idx > 0) {
            digits[idx - 1].value = '';
            digits[idx - 1].classList.remove('filled');
            digits[idx - 1].focus();
            syncOtp();
        }
    });

    inp.addEventListener('paste', function (e) {
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        if (pasted.length === 6) {
            pasted.split('').forEach((ch, i) => {
                digits[i].value = ch;
                digits[i].classList.add('filled');
            });
            digits[5].focus();
            syncOtp();
            e.preventDefault();
        }
    });
});

function syncOtp() {
    const val = Array.from(digits).map(d => d.value).join('');
    realInp.value = val;
    btnVerify.disabled = val.length < 6;
}

btnVerify.disabled = true;

// ── TIMER COUNTDOWN ──
let seconds = 300;
const timerEl = document.getElementById('timerCount');
const timerInterval = setInterval(() => {
    seconds--;
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    timerEl.textContent = m + ':' + (s < 10 ? '0' : '') + s;
    if (seconds <= 0) {
        clearInterval(timerInterval);
        timerEl.textContent = 'Kadaluarsa';
        timerEl.style.color = '#aaa';
        btnVerify.disabled = true;
        showToast('Kode OTP telah kadaluarsa. Silakan kirim ulang.', 'error');
    }
}, 1000);

// ── TOAST FUNCTION ──
function showToast(msg, type, title) {
    const box   = document.getElementById('toastNotif');
    const icon  = document.getElementById('toastIconI');
    const tTitle = document.getElementById('toastTitle');
    const tMsg  = document.getElementById('toastMsg');

    box.className = 'toast-notif ' + type;
    icon.className = type === 'error' ? 'bi bi-exclamation-circle-fill' : 'bi bi-check-circle-fill';
    tTitle.textContent = title || (type === 'error' ? 'OTP Tidak Valid' : 'Berhasil');
    tMsg.textContent   = msg;
    box.style.display  = 'flex';
    box.style.animation = 'slideUp .3s ease';

    clearTimeout(window._toast);
    window._toast = setTimeout(() => { box.style.display = 'none'; }, 5000);
}

// ── Auto show dari session/error Laravel ──
@if($errors->has('otp'))
    window.addEventListener('DOMContentLoaded', function() {
        showToast("{{ $errors->first('otp') }}", 'error', 'OTP Salah atau Kadaluarsa');
    });
@endif

@if(session('success'))
    window.addEventListener('DOMContentLoaded', function() {
        showToast("{{ session('success') }}", 'success', 'Berhasil');
    });
@endif
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
