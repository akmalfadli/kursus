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
        'base_amount',
        'amount',
        'referral_discount_amount',
        'referral_commission_amount',
        'referral_discount_percentage',
        'payment_status',
        'payment_method',
        'payment_reference',
        'duitku_reference',
        'duitku_response',
        'paid_at',
        'referral_id',
        'referral_code',
        'referral_commission_status',
        'referral_commission_paid_at',
        'referral_usage_recorded_at',
    ];

    protected $casts = [
        'base_amount' => 'decimal:2',
        'amount' => 'decimal:2',
        'referral_discount_amount' => 'decimal:2',
        'referral_commission_amount' => 'decimal:2',
        'duitku_response' => 'array',
        'paid_at' => 'datetime',
        'referral_commission_paid_at' => 'datetime',
        'referral_usage_recorded_at' => 'datetime',
    ];

    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

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

    public function getFormattedDiscountAttribute(): string
    {
        return 'Rp ' . number_format($this->referral_discount_amount, 0, ',', '.');
    }
}