<?php

return [
    /*
    |--------------------------------------------------------------------------
    | M-Pesa Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for Safaricom M-Pesa integration
    |
    */

    'environment' => env('MPESA_ENVIRONMENT', 'sandbox'), // 'sandbox' or 'production'
    
    'consumer_key' => env('MPESA_CONSUMER_KEY'),
    
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    
    'business_short_code' => env('MPESA_BUSINESS_SHORT_CODE'),
    
    'passkey' => env('MPESA_PASSKEY'),
    
    'callback_url' => env('MPESA_CALLBACK_URL', env('APP_URL') . '/api/mpesa/callback'),
    
    /*
    |--------------------------------------------------------------------------
    | API URLs
    |--------------------------------------------------------------------------
    */
    
    'urls' => [
        'sandbox' => [
            'oauth' => 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
            'stk_push' => 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            'stk_query' => 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query',
        ],
        'production' => [
            'oauth' => 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
            'stk_push' => 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            'stk_query' => 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query',
        ],
    ],
];