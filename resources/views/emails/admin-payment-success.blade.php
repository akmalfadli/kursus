{{-- resources/views/emails/admin-payment-success.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembayaran Berhasil</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success-header { background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; margin: -20px -20px 20px -20px; }
        .button { display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; }
        .stats-box { background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="success-header">
                <h2>🎉 Pembayaran Berhasil!</h2>
                <p>Customer baru telah bergabung</p>
            </div>

            <p>Kabar baik! Ada pembayaran yang berhasil diproses:</p>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Invoice ID</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->invoice_id }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Customer</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        {{ $transaction->user_name }}<br>
                        <small>{{ $transaction->user_email }}</small>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Jumlah</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong style="color: #28a745;">{{ $transaction->formatted_amount }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Metode Pembayaran</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->payment_method ?? 'Duitku Payment' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Referensi</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->payment_reference ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Dibayar Pada</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->paid_at->format('d/m/Y H:i') }} WIB</td>
                </tr>
            </table>

            <div class="stats-box">
                <h3 style="margin-top: 0;">📊 Action Items:</h3>
                <ul style="margin: 0;">
                    <li>✅ Email konfirmasi telah dikirim ke customer</li>
                    <li>🎓 Customer perlu diberikan akses ke materi kursus</li>
                    <li>📧 Pertimbangkan mengirim email welcome sequence</li>
                    <li>📞 Follow up jika diperlukan untuk memastikan kepuasan customer</li>
                </ul>
            </div>

            <p style="margin-top: 20px; text-align: center;">
                <a href="{{ config('app.url') }}/admin/transactions/{{ $transaction->id }}" class="button">
                    👁️ Lihat Detail & Kirim Akses Kursus
                </a>
            </p>

            <div style="margin-top: 20px; padding: 15px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 4px;">
                <p style="margin: 0; color: #0c5460;">
                    <strong>💡 Tip:</strong> Respon cepat terhadap customer baru meningkatkan kepuasan dan review positif.
                    Pertimbangkan untuk mengirim pesan personal kepada {{ $transaction->user_name }}.
                </p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
            <p>Email ini dikirim otomatis dari sistem Kursus Ujian Perangkat Desa</p>
        </div>
    </div>
</body>
</html>
