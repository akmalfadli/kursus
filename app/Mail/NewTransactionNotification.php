<?php
// app/Mail/NewTransactionNotification.php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTransactionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Transaction $transaction
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Transaksi Baru - ' . $this->transaction->invoice_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-transaction-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
