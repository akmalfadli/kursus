{{-- resources/views/emails/admin-transaction-notification.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaksi Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .status-paid { color: #28a745; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-failed { color: #dc3545; font-weight: bold; }
        .button { display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>💰 Transaksi Baru</h2>

            <p>Ada transaksi baru di sistem:</p>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Invoice ID</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->invoice_id }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Customer</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->user_name }}<br>{{ $transaction->user_email }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Jumlah</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->formatted_amount }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Status</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        <span class="status-{{ $transaction->payment_status }}">
                            {{ match($transaction->payment_status) {
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Lunas',
                                'failed' => 'Gagal',
                                'expired' => 'Kadaluarsa',
                                default => ucfirst($transaction->payment_status)
                            } }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Telepon</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->user_phone ?? 'Tidak ada' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Tanggal</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $transaction->created_at->format('d/m/Y H:i') }} WIB</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                <a href="{{ config('app.url') }}/admin/transactions/{{ $transaction->id }}" class="button">
                    👁️ Lihat Detail Transaksi
                </a>
            </p>

            @if($transaction->payment_status === 'pending')
            <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px;">
                <p style="margin: 0; color: #856404;">
                    <strong>⏰ Action Required:</strong> Transaksi ini masih menunggu pembayaran.
                    Pantau status pembayaran dan berikan bantuan jika customer mengalami kesulitan.
                </p>
            </div>
            @endif
        </div>

        <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #666;">
            <p>Email ini dikirim otomatis dari sistem Kursus Ujian Perangkat Desa</p>
        </div>
    </div>
</body>
</html>
