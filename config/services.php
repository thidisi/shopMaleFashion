<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    // 'gitlab' => [
    //     'client_id' => '3d18ada7eb16f02c8113d28b9c81d32301073024b0532de30ff2de5e1f853f92',
    //     'client_secret' => 'babe1c0a541e4cf69d6d15c4daf05b6f8fe1bf3bcd5e8a3c3bb68948856601a0',
    //     'redirect' => 'http://localhost:8000/auth/callback/gitlab',
    // ],
];
