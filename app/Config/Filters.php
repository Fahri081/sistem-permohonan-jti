<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;

use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Filter Aliases
     *
     * @var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // Filter role untuk sistem JTI
        'role'          => \App\Filters\RoleFilter::class,
    ];

    /**
     * Required Filters
     */
    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],

        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    /**
     * Global Filters
     */
    public array $globals = [
        'before' => [
            // Filter global tambahan bisa ditambahkan nanti.
            // CSRF tidak dibuat global dulu agar kita lebih mudah
            // mengembangkan form login dan pengajuan.
        ],

        'after' => [
            // Filter global tambahan bisa ditambahkan nanti.
        ],
    ];

    /**
     * Method Filters
     */
    public array $methods = [];

    /**
     * URI Filters
     */
    public array $filters = [];
}