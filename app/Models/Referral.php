<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'label',
        'referrer_name',
        'referrer_contact',
        'discount_percentage',
        'commission_percentage',
        'commission_flat',
        'max_usage',
        'usage_count',
        'valid_from',
        'valid_until',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'commission_flat' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function isActive(): bool
    {
        $now = now();

        if (!$this->is_active) {
            return false;
        }

        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        if ($this->max_usage !== null && $this->usage_count >= $this->max_usage) {
            return false;
        }

        return true;
    }
}
