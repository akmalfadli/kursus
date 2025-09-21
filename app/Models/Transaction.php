<?php
// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'user_name',
        'user_email',
        'user_phone',
        'amount',
        'payment_status',
        'payment_method',
        'payment_reference',
        'duitku_reference',
        'duitku_response',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'duitku_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->payment_status) {
            'paid' => 'success',
            'pending' => 'warning',
            'failed' => 'danger',
            'expired' => 'gray',
            default => 'secondary'
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}