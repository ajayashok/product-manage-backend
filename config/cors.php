<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Allow API and Sanctum CSRF paths
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'], // Exact domain of your Next.js frontend
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Allow credentials (cookies)
];
