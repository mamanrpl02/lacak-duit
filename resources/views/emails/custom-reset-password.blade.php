<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Kata Sandi</title>
</head>

<body style="margin:0; padding:0; font-family:'Segoe UI', Arial, sans-serif; background-color:#f3f4f6;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">
                
                <!-- Logo di luar card -->
                <div style="margin-bottom:16px; text-align:center;">
                    <img src="https://laravel.com/img/logomark.min.svg" width="48" height="48" alt="Logo">
                </div>

                <!-- Card -->
                <table role="presentation" width="480" cellpadding="0" cellspacing="0"
                    style="background-color:white; border-radius:12px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.08); border-top:4px solid #2563eb; border-bottom:4px solid #2563eb;">
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h3 style="color:#111827; margin-top:0;">Halo {{ $name }}</h3>
                            <p style="color:#374151; font-size:15px; line-height:1.6; margin:16px 0;">
                                Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda.
                                Klik tombol di bawah ini untuk membuat kata sandi baru.
                            </p>
                            <p style="text-align:center; margin:32px 0;">
                                <a href="{{ $url }}"
                                   style="display:inline-block; padding:12px 32px; color:#2563eb; border:2px solid #2563eb; border-radius:6px; text-decoration:none; font-weight:600;">
                                   Reset Kata Sandi
                                </a>
                            </p>
                            <p style="color:#6b7280; font-size:14px; margin-top:16px;">
                                Jika Anda tidak meminta reset kata sandi, abaikan email ini.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding:16px; color:#9ca3af; font-size:13px; border-top:1px solid #e5e7eb;">
                            © {{ date('Y') }} <strong>Fathwork</strong>. Semua hak dilindungi.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
