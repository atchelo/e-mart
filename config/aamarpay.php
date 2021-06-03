<?php

return [
    'store_id' => env('AAMARPAY_STORE_ID',''),
    'signature_key' => env('AAMARPAY_KEY',''),
    'sandbox' => env('AAMARPAY_SANDBOX', true),
    'redirect_url' => [
        'success' => [
            'url' => '/success/aamarpay' // payment.success
        ],
        'cancel' => [
            'url' => '/order-review' // payment/cancel or you can use route also
        ]
    ]
];
