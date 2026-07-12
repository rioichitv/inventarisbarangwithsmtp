@extends('layouts.app')

@section('title', 'Web Config')

@section('content')

<div class="page-title">
    <i class="bi bi-gear-fill"></i> Web Config
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="form-section">
            <div class="form-section-header">
                <i class="bi bi-envelope-at"></i> Pengaturan SMTP & Keamanan Login
            </div>
            <div class="form-section-body" style="padding: 24px">
                <form method="POST" action="{{ route('settings.web-config.store') }}" novalidate>
                    @csrf

                    <h5 style="color: #3b2db5; font-weight: 700; margin-bottom: 16px; border-bottom: 1.5px solid #f0f0f0; padding-bottom: 8px">
                        <i class="bi bi-send me-1"></i> Konfigurasi SMTP
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <label class="form-label">SMTP Host <span class="required">*</span></label>
                            <input type="text" name="smtp_host" value="{{ old('smtp_host', $settings['smtp_host'] ?? '') }}" class="form-control" placeholder="e.g. smtp.gmail.com" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SMTP Port <span class="required">*</span></label>
                            <input type="number" name="smtp_port" value="{{ old('smtp_port', $settings['smtp_port'] ?? '587') }}" class="form-control" placeholder="e.g. 587" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SMTP Username</label>
                            <input type="text" name="smtp_username" value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}" class="form-control" placeholder="e.g. user@gmail.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SMTP Password</label>
                            <input type="password" name="smtp_password" value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}" class="form-control" placeholder="Password SMTP / App Password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SMTP Encryption <span class="required">*</span></label>
                            <select name="smtp_encryption" class="form-select" required>
                                <option value="none" {{ (old('smtp_encryption', $settings['smtp_encryption'] ?? '') == 'none') ? 'selected' : '' }}>None</option>
                                <option value="tls" {{ (old('smtp_encryption', $settings['smtp_encryption'] ?? '') == 'tls') ? 'selected' : '' }}>TLS (Recommended for Port 587)</option>
                                <option value="ssl" {{ (old('smtp_encryption', $settings['smtp_encryption'] ?? '') == 'ssl') ? 'selected' : '' }}>SSL (Recommended for Port 465)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pengirim Email (From Email) <span class="required">*</span></label>
                            <input type="email" name="smtp_from_address" value="{{ old('smtp_from_address', $settings['smtp_from_address'] ?? '') }}" class="form-control" placeholder="e.g. no-reply@domain.com" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama Pengirim (From Name) <span class="required">*</span></label>
                            <input type="text" name="smtp_from_name" value="{{ old('smtp_from_name', $settings['smtp_from_name'] ?? 'Data Inventaris') }}" class="form-control" placeholder="e.g. Admin Inventaris" required>
                        </div>
                    </div>

                    <h5 style="color: #3b2db5; font-weight: 700; margin-bottom: 16px; border-bottom: 1.5px solid #f0f0f0; padding-bottom: 8px">
                        <i class="bi bi-shield-lock-fill me-1"></i> Keamanan Login
                    </h5>

                    <div class="form-check form-switch mb-4" style="padding-left: 2.5em;">
                        <input class="form-check-input" type="checkbox" name="otp_login_enabled" id="otpSwitch" value="1" {{ (old('otp_login_enabled', $settings['otp_login_enabled'] ?? '0') == '1') ? 'checked' : '' }} style="width: 2.5em; height: 1.25em; cursor: pointer">
                        <label class="form-check-label" for="otpSwitch" style="font-weight: 600; cursor: pointer; margin-left: 8px">
                            Aktifkan OTP Login (Kirim kode 6-digit ke email admin saat login)
                        </label>
                        <div class="text-muted" style="font-size: 12px; margin-top: 4px; margin-left: 8px">
                            Sistem akan meminta kode verifikasi OTP yang dikirim melalui email SMTP di atas sebelum memberikan akses masuk ke Dashboard.
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;justify-content:flex-end;border-top:1px solid #f0f0f0;padding-top:20px">
                        <button type="submit" class="btn-save" style="padding:10px 24px;font-size:13px;border-radius:8px">
                            <i class="bi bi-save me-1"></i> Simpan Konfigurasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function() {
    $('form').on('submit', function(e) {
        let errors = [];

        if (!$('input[name="smtp_host"]').val().trim())
            errors.push({ msg: 'SMTP Host wajib diisi', el: $('input[name="smtp_host"]') });

        if (!$('input[name="smtp_port"]').val().trim())
            errors.push({ msg: 'SMTP Port wajib diisi', el: $('input[name="smtp_port"]') });

        if (!$('input[name="smtp_from_address"]').val().trim())
            errors.push({ msg: 'Pengirim Email wajib diisi', el: $('input[name="smtp_from_address"]') });

        if (!$('input[name="smtp_from_name"]').val().trim())
            errors.push({ msg: 'Nama Pengirim wajib diisi', el: $('input[name="smtp_from_name"]') });

        if (errors.length > 0) {
            e.preventDefault();
            e.stopPropagation();
            showToast(errors[0].msg, 'error');
            if (errors[0].el) {
                errors[0].el.focus();
            }
            return false;
        }
    });
});
</script>
@endpush
