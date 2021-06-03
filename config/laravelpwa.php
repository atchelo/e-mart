<?php


return [
    'name' => env('APP_NAME','My PWA APP'),
    'manifest' => [
        'name' => env('APP_NAME','My PWA APP'),
        'short_name' => env('APP_NAME','My PWA APP'),
        'start_url' => env('APP_URL', '/'),
        'background_color' => env('PWA_BG_COLOR','#ffffff'),
        'theme_color' => env('PWA_THEME_COLOR','#000000'),
        'display' => 'standalone',
        'orientation' => 'portrait',
        'status_bar' => 'black-translucent',
        'icons' => [
            '48x48' => [
                'path' => env('APP_URL').'images/icons/icon_48x48.png',
                'purpose' => 'maskable any',
            ],
            '72x72' => [
                'path' => env('APP_URL').'images/icons/icon_72x72.png',
                'purpose' => 'maskable any',
            ],
            '96x96' => [
                'path' => env('APP_URL').'images/icons/icon_96x96.png',
                'purpose' => 'maskable any',
            ],
            '128x128' => [
                'path' => env('APP_URL').'images/icons/icon_128x128.png',
                'purpose' => 'maskable any',
            ],
            '144x144' => [
                'path' => env('APP_URL').'images/icons/icon_144x144.png',
                'purpose' => 'maskable any',
            ],
            '192x192' => [
                'path' => env('APP_URL').'images/icons/icon_192x192.png',
                'purpose' => 'maskable any',
            ],
            '256x256' => [
                'path' => env('APP_URL').'images/icons/icon_256x256.png',
                'purpose' => 'any',
            ],
            '512x512' => [
                'path' => env('APP_URL').'images/icons/icon_512x512.png',
                'purpose' => 'any',
            ],
        ],
        'splash' => [
            '640x1136' =>  env('APP_URL').'images/icons/splash-640x1136.png',
            '750x1334' =>  env('APP_URL').'images/icons/splash-750x1334.png',
            '828x1792' =>  env('APP_URL').'images/icons/splash-828x1792.png',
            '1125x2436' => env('APP_URL').'images/icons/splash-1125x2436.png',
            '1242x2208' => env('APP_URL').'images/icons/splash-1242x2208.png',
            '1536x2048' => env('APP_URL').'images/icons/splash-1536x2048.png',
            '1668x2224' => env('APP_URL').'images/icons/splash-1668x2224.png',
            '1668x2388' => env('APP_URL').'images/icons/splash-1668x2388.png',
            '2048x2732' => env('APP_URL').'images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Login',
                'description' => 'To access login',
                'url' => env('SHORTCUT_ICON_LOGIN_LINK',env('APP_URL').'login'),
                'icons' => [
                    "src" => env('SHORTCUT_ICON_LOGIN',env('APP_URL').'images/icons/login_5fe1ccf7d95f4.png'),
                    "purpose" => "maskable any",
                    "sizes" => "96x96"
                ],
            ],
            [
                'name' => 'My Cart',
                'description' => 'To view your cart',
                'url' => env('SHORTCUT_ICON_CART_LINK',env('APP_URL').'cart'),
                'icons' => [
                    "src" => env('SHORTCUT_ICON_CART',env('APP_URL').'images/icons/cart_5fe1ccf7d7478.png'),
                    "purpose" => "maskable any",
                    "sizes" => "96x96"
                ],
            ],
            [
                'name' => 'Wishlist',
                'description' => 'To view your wishlist',
                'url' => env('SHORTCUT_ICON_WISHLIST_LINK',env('APP_URL').'wishlist'),
                'icons' => [
                    "src" => env('SHORTCUT_ICON_WISHLIST',env('APP_URL').'images/icons/wishlist_5fe1ccf7d86c9.png'),
                    "purpose" => "maskable any",
                    "sizes" => "96x96"
                ],
            ],
        ],
        'custom' => [],
    ],
];