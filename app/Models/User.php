<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
        'notes',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Filament Admin Access
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin' && $this->is_active;
    }

    // Relationships
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_email', 'email');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Accessors
    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

    public function getIsCustomerAttribute(): bool
    {
        return $this->role === 'customer';
    }

    public function getTotalSpentAttribute(): int
    {
        return $this->transactions()->where('payment_status', 'paid')->sum('amount');
    }

    public function getTransactionCountAttribute(): int
    {
        return $this->transactions()->count();
    }

    public function getLastTransactionAttribute()
    {
        return $this->transactions()->latest()->first();
    }
}
