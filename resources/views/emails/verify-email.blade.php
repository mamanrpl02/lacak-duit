<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email Anda</title>
</head>

<body style="margin:0; padding:0; font-family:'Segoe UI', Arial, sans-serif; background-color:#f3f4f6;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">

                <!-- Logo -->
                <div style="margin-bottom:16px; text-align:center;">
                    <img src="https://ibb.co.com/WNfRsDD7" width="48" height="48" alt="Logo">
                </div>

                <!-- Card -->
                <table role="presentation" width="480" cellpadding="0" cellspacing="0"
                    style="background-color:white; border-radius:12px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.08); border-top:4px solid #2563eb; border-bottom:4px solid #2563eb;">

                    <tr>
                        <td style="padding:32px;">
                            <h3 style="color:#111827; margin-top:0;">Halo, {{ $name }} 👋</h3>

                            <p style="color:#374151; font-size:15px; line-height:1.6; margin:16px 0;">
                                Selamat datang di <strong>LacakDuit</strong>!
                                Sebelum Anda dapat menggunakan akun ini, kami perlu memastikan bahwa alamat email Anda
                                benar.
                                Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.
                            </p>

                            <p style="text-align:center; margin:32px 0;">
                                <a href="{{ $url }}"
                                    style="display:inline-block; padding:12px 32px; background-color:#2563eb; color:white; border-radius:6px; text-decoration:none; font-weight:600;">
                                    Verifikasi Email Sekarang
                                </a>
                            </p>

                            <p style="color:#6b7280; font-size:14px; margin-top:16px;">
                                Jika Anda tidak membuat akun ini, abaikan email ini.
                                Tautan ini akan kedaluwarsa dalam waktu <strong>60 menit</strong>.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="padding:16px; color:#9ca3af; font-size:13px; border-top:1px solid #e5e7eb;">
                            © {{ date('Y') }} <strong>LacakDuit</strong>. Semua hak dilindungi.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
