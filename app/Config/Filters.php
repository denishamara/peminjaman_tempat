<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Cors;
use App\Filters\AuthFilter;
use App\Filters\GuestFilter;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'forcehttps'    => ForceHTTPS::class,
        'cors'          => Cors::class,

        // ✅ Custom filters
        'auth'    => AuthFilter::class,
        'guest'   => GuestFilter::class,
    ];

    public array $required = [];

    public array $globals = [
        'before' => [
            // 'csrf', // Aktifkan kalau perlu proteksi form
        ],
        'after'  => [
            'toolbar', // ✅ biar debug tetap jalan
            // ❌ jangan pakai 'noCache' di sini
        ],
    ];

    public array $methods = [];
    public array $filters = [];
}
