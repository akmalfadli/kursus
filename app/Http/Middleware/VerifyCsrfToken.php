<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Duitku payment callback - external POST request
        'payment/callback',

        // Alternative patterns if needed:
        // 'payment/*',  // Exempts all payment routes
        // 'api/*',      // Exempts all API routes
    ];
}
