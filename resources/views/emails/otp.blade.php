<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Login</title>
</head>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;
             background:#f5f5f0;margin:0;padding:40px 20px;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
           style="max-width:480px;background:#ffffff;border-radius:16px;overflow:hidden;
                  box-shadow:0 2px 16px rgba(0,0,0,.08);">

        <!-- Header -->
        <tr>
            <td style="padding:24px 32px;border-bottom:1px solid #f0f0f0;">
                <h2 style="color:#111827;margin:0;font-size:20px;font-weight:700;letter-spacing:-0.3px;">
                    Verifikasi Login — Inventaris IT
                </h2>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding:28px 32px 12px;">
                <p style="font-size:15px;margin:0 0 12px;color:#374151;line-height:1.5">
                    Halo <strong style="color:#111827;">{{ $name }}</strong>,
                </p>
                <p style="font-size:14px;line-height:1.7;margin:0 0 28px;color:#6b7280;">
                    Kami menerima permintaan untuk masuk ke akun Anda.
                    Silakan masukkan kode berikut pada halaman verifikasi:
                </p>

                <!-- OTP single box — 1 kotak panjang gelap -->
                <table align="center" border="0" cellpadding="0" cellspacing="0"
                       style="margin:0 auto 28px;width:100%;">
                    <tr>
                        <td align="center">
                            <div style="background-color:#111827;
                                        border-radius:14px;
                                        padding:18px 24px;
                                        display:inline-block;
                                        width:100%;
                                        max-width:320px;
                                        box-sizing:border-box;">
                                <span style="display:block;
                                             font-family:'Courier New',Courier,monospace;
                                             font-size:32px;
                                             font-weight:800;
                                             color:#ffffff;
                                             letter-spacing:12px;
                                             text-align:center;
                                             line-height:1;
                                             white-space:nowrap;
                                             padding-left:12px;">{{ $otp }}</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <p style="font-size:13px;color:#9ca3af;text-align:center;margin:0 0 6px;">
                    Kode ini berlaku selama <strong style="color:#374151;">5 menit</strong>
                </p>
                <p style="font-size:13px;color:#9ca3af;text-align:center;margin:0 0 24px;">
                    Jika Anda tidak merasa melakukan login, abaikan email ini.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background:#f9fafb;padding:16px 32px;text-align:center;
                       border-top:1px solid #f3f4f6;">
                <p style="font-size:12px;color:#9ca3af;margin:0;">
                    © {{ date('Y') }} Inventaris IT — Sistem Manajemen Aset
                </p>
            </td>
        </tr>

    </table>
</body>
</html>
