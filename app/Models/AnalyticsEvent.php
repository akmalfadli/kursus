<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = [
        'event_type',
        'event_data',
        'session_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'event_data' => 'array',
    ];
}
