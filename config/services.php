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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'pubg' => [
    'api_key' => env('PUBG_API_KEY'),
    'base_uri' => 'https://api.pubg.com/shards/steam/players'
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'social' => [
        'steam' => [
            'client_id' => env('STEAM_CLIENT_ID'),
            'client_secret' => env('STEAM_CLIENT_SECRET'),
            'redirect' => env('STEAM_REDIRECT_URL'),
        ],
        'xbox' => [
            'client_id' => env('XBOX_CLIENT_ID'),
            'client_secret' => env('XBOX_CLIENT_SECRET'),
            'redirect' => env('XBOX_REDIRECT_URL'),
        ],
    ],
    

];
