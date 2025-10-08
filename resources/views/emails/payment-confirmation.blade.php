{{-- resources/views/emails/payment-confirmation.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - {{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #10b981, #059669); padding: 40px 30px; text-align: center;">
                            <div style="width: 80px; height: 80px; background-color: #ffffff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h1 style="color: #ffffff; margin: 0 0 10px; font-size: 28px; font-weight: 600;">
                                Pembayaran Berhasil!
                            </h1>
                            <p style="color: #e0f2f1; margin: 0; font-size: 16px;">
                                Terima kasih atas pembayaran Anda
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #2d3748; font-size: 16px; line-height: 1.6;">
                                Halo <strong>{{ $transaction->user_name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px; color: #4a5568; font-size: 15px; line-height: 1.6;">
                                Pembayaran Anda telah berhasil diproses. Berikut adalah detail transaksi Anda:
                            </p>

                            <!-- Transaction Details Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7fafc; border: 1px solid #e2e8f0; border-radius: 6px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <p style="margin: 0 0 15px; color: #2d3748; font-size: 15px; font-weight: 600;">
                                            📋 Detail Transaksi
                                        </p>
                                        <table width="100%" cellpadding="8" cellspacing="0">
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="color: #718096; font-size: 14px;">Invoice ID:</td>
                                                <td style="color: #2d3748; font-size: 14px; font-weight: 500; text-align: right;">
                                                    {{ $transaction->invoice_id }}
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="color: #718096; font-size: 14px;">Produk:</td>
                                                <td style="color: #2d3748; font-size: 14px; font-weight: 500; text-align: right;">
                                                    {{ $courseName }}
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="color: #718096; font-size: 14px;">Jumlah:</td>
                                                <td style="color: #10b981; font-size: 16px; font-weight: 600; text-align: right;">
                                                    {{ $transaction->formatted_amount }}
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="color: #718096; font-size: 14px;">Metode Pembayaran:</td>
                                                <td style="color: #2d3748; font-size: 14px; font-weight: 500; text-align: right;">
                                                    {{ $transaction->payment_method ?? 'Duitku Payment' }}
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="color: #718096; font-size: 14px;">Tanggal Pembayaran:</td>
                                                <td style="color: #2d3748; font-size: 14px; font-weight: 500; text-align: right;">
                                                    {{ $transaction->paid_at->format('d F Y, H:i') }} WIB
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #718096; font-size: 14px;">Status:</td>
                                                <td style="text-align: right;">
                                                    <span style="background-color: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 600;">
                                                        ✅ Lunas
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #eff6ff; border-left: 3px solid #3b82f6; border-radius: 4px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 15px; color: #1e40af; font-size: 15px; font-weight: 600;">
                                            🚀 Langkah Selanjutnya
                                        </p>
                                        <ol style="margin: 0; padding-left: 20px; color: #1e3a8a; font-size: 14px; line-height: 1.8;">
                                            <li style="margin-bottom: 8px;">Cek email lain dari kami yang berisi kredensial akses kursus</li>
                                            <li style="margin-bottom: 8px;">Login ke platform menggunakan email dan password yang diberikan</li>
                                            <li style="margin-bottom: 8px;">Mulai belajar dan akses semua materi kursus</li>
                                            <li>Hubungi support jika Anda memerlukan bantuan</li>
                                        </ol>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ config('app.url') }}/admin/login"
                                           style="display: inline-block; padding: 14px 40px; background-color: #3b82f6; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: 600; font-size: 15px; letter-spacing: 0.3px;">
                                            Akses Platform Kursus
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Important Notice -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fef3c7; border-left: 3px solid #f59e0b; border-radius: 4px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <p style="margin: 0; color: #78350f; font-size: 14px; line-height: 1.5;">
                                            <strong>💡 Penting:</strong> Jika Anda belum menerima email dengan kredensial akses dalam 10 menit, silakan cek folder spam atau hubungi support kami.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 25px 0 0; color: #4a5568; font-size: 14px; line-height: 1.6;">
                                Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim support kami di <a href="mailto:{{ $supportEmail }}" style="color: #3b82f6; text-decoration: none;">{{ $supportEmail }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f7fafc; padding: 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 5px; color: #2d3748; font-size: 14px;">
                                Terima kasih telah mempercayai kami!
                            </p>
                            <p style="margin: 0 0 15px; color: #4a5568; font-size: 13px;">
                                Tim {{ config('app.name') }}
                            </p>
                            <p style="margin: 15px 0 0; color: #718096; font-size: 12px; line-height: 1.5;">
                                © {{ date('Y') }} {{ config('app.name') }}. Hak Cipta Dilindungi.<br>
                                Email ini dikirim ke {{ $transaction->user_email }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
