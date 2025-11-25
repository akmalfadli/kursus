<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - {{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #2c5282; padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0 0 10px; font-size: 28px; font-weight: 600;">
                                Selamat Datang
                            </h1>
                            <p style="color: #e2e8f0; margin: 0; font-size: 16px;">
                                Digidesa - Kursus Perangkat Desa
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #2d3748; font-size: 16px; line-height: 1.6;">
                                Halo <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4a5568; font-size: 15px; line-height: 1.6;">
                                Terima kasih telah bergabung dengan Digidesa - Kursus Perangkat Desa. Akun Anda telah berhasil dibuat dan siap digunakan.
                            </p>

                            <!-- Credentials Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7fafc; border: 1px solid #e2e8f0; border-radius: 6px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <p style="margin: 0 0 15px; color: #2d3748; font-size: 15px; font-weight: 600;">
                                            Informasi Login Anda
                                        </p>
                                        <table width="100%" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; padding: 8px 0;">Email:</td>
                                                <td style="color: #2d3748; font-size: 14px; font-weight: 500; text-align: right; padding: 8px 0;">
                                                    {{ $user->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px; padding: 8px 0; vertical-align: top;">Password Sementara:</td>
                                                <td style="text-align: right; padding: 8px 0;">
                                                    <code style="background-color: #edf2f7; color: #2d3748; padding: 6px 12px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; display: inline-block;">{{ $tempPassword }}</code>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Notice -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fff5f5; border-left: 3px solid #fc8181; border-radius: 4px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <p style="margin: 0; color: #742a2a; font-size: 14px; line-height: 1.5;">
                                            <strong>Catatan Keamanan:</strong> Demi keamanan akun Anda, harap segera ubah password ini setelah login pertama kali.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ config('app.course_platform_url') }}"
                                           style="display: inline-block; padding: 14px 40px; background-color: #2c5282; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: 600; font-size: 15px; letter-spacing: 0.3px;">
                                            Masuk ke Akun Saya
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps -->
                            <p style="margin: 30px 0 15px; color: #2d3748; font-size: 15px; font-weight: 600;">
                                Langkah Selanjutnya
                            </p>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="color: #4a5568; font-size: 14px; line-height: 1.8; padding-left: 20px;">
                                        <p style="margin: 0 0 10px;">1. Login menggunakan kredensial di atas</p>
                                        <p style="margin: 0 0 10px;">2. Ubah password Anda melalui menu pengaturan</p>
                                        <p style="margin: 0 0 10px;">3. Lengkapi informasi profil Anda</p>
                                        <p style="margin: 0;">4. Mulai akses materi pembelajaran</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Tips -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #ebf8ff; border-radius: 4px; margin: 25px 0 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px; color: #2c5282; font-size: 14px; font-weight: 600;">
                                            Tips Keamanan Akun
                                        </p>
                                        <p style="margin: 0 0 8px; color: #2d3748; font-size: 13px; line-height: 1.6;">
                                            • Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol
                                        </p>
                                        <p style="margin: 0 0 8px; color: #2d3748; font-size: 13px; line-height: 1.6;">
                                            • Jangan pernah membagikan password Anda kepada siapapun
                                        </p>
                                        <p style="margin: 0; color: #2d3748; font-size: 13px; line-height: 1.6;">
                                            • Selalu logout setelah selesai menggunakan platform
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f7fafc; padding: 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 15px; color: #2d3748; font-size: 15px; font-weight: 600;">
                                Butuh Bantuan?
                            </p>
                            <p style="margin: 0 0 5px; color: #4a5568; font-size: 14px;">
                                Email: <a href="mailto:{{ config('mail.from.address') }}" style="color: #2c5282; text-decoration: none;">{{ config('mail.from.address') }}</a>
                            </p>
                            <p style="margin: 0 0 20px; color: #4a5568; font-size: 14px;">
                                WhatsApp: <a href="https://wa.me/62085774397927" style="color: #2c5282; text-decoration: none;">+62 8577-4397-927</a>
                            </p>
                            <p style="margin: 20px 0 0; color: #718096; font-size: 12px; line-height: 1.5;">
                                © {{ date('Y') }} Digidesa - Kursus Perangkat Desa. <br>
                                Hak Cipta Dilindungi.
                            </p>
                        </td>
                    </tr>

                    <!-- Legal Footer -->
                    <tr>
                        <td style="padding: 15px 30px; text-align: center; background-color: #edf2f7;">
                            <p style="margin: 0; color: #a0aec0; font-size: 11px; line-height: 1.5;">
                                Email ini dikirim ke {{ $user->email }} karena akun baru telah dibuat untuk Anda.<br>
                                Ini adalah email otomatis, harap tidak membalas email ini.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
