<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    'version' => '2.3',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
       
        /*
         * Package Service Providers...
         */
         UxWeb\SweetAlert\SweetAlertServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Kyslik\ColumnSortable\ColumnSortableServiceProvider::class,
        Yajra\Datatables\DatatablesServiceProvider::class,
         'Intervention\Image\ImageServiceProvider',
         Cartalyst\Stripe\Laravel\StripeServiceProvider::class,
         Laravel\Socialite\SocialiteServiceProvider::class,
        Laravolt\Avatar\ServiceProvider::class,
        ConsoleTVs\Charts\ChartsServiceProvider::class,
        Arcanedev\NoCaptcha\NoCaptchaServiceProvider::class,
        App\Providers\GlobalSeoProvider::class,
        Orangehill\Iseed\IseedServiceProvider::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Datatables' => Yajra\Datatables\Facades\Datatables::class,
         'Image' => 'Intervention\Image\Facades\Image',
         'Stripe' => Cartalyst\Stripe\Laravel\Facades\Stripe::class,
         'Payment' => Tzsk\Payu\Facade\Payment::class,
         'Socialite' => Laravel\Socialite\Facades\Socialite::class,
         'Alert' => UxWeb\SweetAlert\SweetAlert::class,
         'Avatar'    => Laravolt\Avatar\Facade::class,
         'Share' => Jorenvh\Share\ShareFacade::class,
         'HTMLMin' => HTMLMin\HTMLMin\Facades\HTMLMin::class,
         'Tracker' => App\HelpersApp\Helpers\Tracker::class,
         'ProductPrice' => App\HelpersApp\Helpers\ProductPrice::class,
         'ProductRating' => App\HelpersApp\Helpers\ProductRating::class
    ],

    'debug_hide' => [
        '_ENV' => [
            'APP_KEY',
            'DB_USERNAME',
            'DB_DATABASE',
            'DB_PASSWORD',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'PAYPAL_CLIENT_ID',
            'PAYPAL_SECRET',
            'STRIPE_KEY',
            'STRIPE_SECRET',
            'PAYU_MERCHANT_KEY',
            'PAYU_MERCHANT_SALT',
            'PAYU_AUTH_HEADER',
            'IM_API_KEY',
            'IM_AUTH_TOKEN',
            'FACEBOOK_CLIENT_ID',
            'FACEBOOK_CLIENT_SECRET',
            'GOOGLE_CLIENT_ID',
            'GOOGLE_CLIENT_SECRET',
            'RAZOR_PAY_KEY',
            'RAZOR_PAY_SECRET',
            'GITLAB_CLIENT_ID',
            'GITLAB_CLIENT_SECRET',
            'PAYTM_MERCHANT_ID',
            'PAYTM_MERCHANT_KEY',
            'NOCAPTCHA_SECRET',
            'NOCAPTCHA_SITEKEY',
            'BRAINTREE_MERCHANT_ACCOUNT_ID',
            'BRAINTREE_MERCHANT_ID',
            'BRAINTREE_PUBLIC_KEY',
            'BRAINTREE_PRIVATE_KEY',
            'MESSENGER_CHAT_BUBBLE_URL',
            'OPEN_EXCHANGE_RATE_KEY',
            'MERCHANT_EMAIL',
            'PAYSTACK_PAYMENT_URL',
            'PAYSTACK_SECRET_KEY',
            'PAYSTACK_PUBLIC_KEY',
            'TWITTER_API_KEY',
            'TWITTER_SECRET_KEY',
            'LINKEDIN_CLIENT_ID',
            'LINKEDIN_SECRET',
            'LINKEDIN_CALLBACK',
            'AMAZON_LOGIN_ID',
            'AMAZON_LOGIN_SECRET',
            'AMAZON_LOGIN_CALLBACK',
            'IYZIPAY_API_KEY',
            'IYZIPAY_SECRET_KEY',
            'STORE_ID',
            'STORE_PASSWORD',
            'AAMARPAY_STORE_ID',
            'AAMARPAY_KEY',
            'TWILIO_SID',
            'TWILIO_AUTH_TOKEN',
            'TWILIO_NUMBER',
            'ONESIGNAL_APP_ID',
            'ONESIGNAL_REST_API_KEY',
            'MSG91_AUTH_KEY',
            'OMISE_PUBLIC_KEY',
            'OMISE_SECRET_KEY',
            'RAVE_PUBLIC_KEY',
            'RAVE_SECRET_KEY',
            'SKRILL_API_PASSWORD',
            'SKRILL_MERCHANT_EMAIL',
            'PAYHERE_BUISNESS_APP_CODE',
            'PAYHERE_APP_SECRET',
            'PAYHERE_MERCHANT_ID',
            'GOOGLE_TAG_MANAGER_ID',
            'BKASH_PASSWORD',
            'BKASH_USER_NAME',
            'BKASH_APP_SECRET',
            'BKASH_APP_KEY',
            'COMPANY_TOKEN',
            'SERVICE_TYPE'
        ],

        '_SERVER' => [
            'APP_KEY',
            'DB_USERNAME',
            'DB_DATABASE',
            'DB_PASSWORD',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'PAYPAL_CLIENT_ID',
            'PAYPAL_SECRET',
            'STRIPE_KEY',
            'STRIPE_SECRET',
            'PAYU_MERCHANT_KEY',
            'PAYU_MERCHANT_SALT',
            'PAYU_AUTH_HEADER',
            'IM_API_KEY',
            'IM_AUTH_TOKEN',
            'FACEBOOK_CLIENT_ID',
            'FACEBOOK_CLIENT_SECRET',
            'GOOGLE_CLIENT_ID',
            'GOOGLE_CLIENT_SECRET',
            'RAZOR_PAY_KEY',
            'RAZOR_PAY_SECRET',
            'GITLAB_CLIENT_ID',
            'GITLAB_CLIENT_SECRET',
            'PAYTM_MERCHANT_ID',
            'PAYTM_MERCHANT_KEY',
            'NOCAPTCHA_SECRET',
            'NOCAPTCHA_SITEKEY',
            'BRAINTREE_MERCHANT_ACCOUNT_ID',
            'BRAINTREE_MERCHANT_ID',
            'BRAINTREE_PUBLIC_KEY',
            'BRAINTREE_PRIVATE_KEY',
            'MESSENGER_CHAT_BUBBLE_URL',
            'OPEN_EXCHANGE_RATE_KEY',
            'MERCHANT_EMAIL',
            'PAYSTACK_PAYMENT_URL',
            'PAYSTACK_SECRET_KEY',
            'PAYSTACK_PUBLIC_KEY',
            'TWITTER_API_KEY',
            'TWITTER_SECRET_KEY',
            'LINKEDIN_CLIENT_ID',
            'LINKEDIN_SECRET',
            'LINKEDIN_CALLBACK',
            'AMAZON_LOGIN_ID',
            'AMAZON_LOGIN_SECRET',
            'AMAZON_LOGIN_CALLBACK',
            'IYZIPAY_API_KEY',
            'IYZIPAY_SECRET_KEY',
            'STORE_ID',
            'STORE_PASSWORD',
            'AAMARPAY_STORE_ID',
            'AAMARPAY_KEY',
            'TWILIO_SID',
            'TWILIO_AUTH_TOKEN',
            'TWILIO_NUMBER',
            'ONESIGNAL_APP_ID',
            'ONESIGNAL_REST_API_KEY',
            'MSG91_AUTH_KEY',
            'OMISE_SECRET_KEY',
            'OMISE_PUBLIC_KEY',
            'RAVE_PUBLIC_KEY',
            'RAVE_SECRET_KEY',
            'SKRILL_API_PASSWORD',
            'SKRILL_MERCHANT_EMAIL',
            'PAYHERE_BUISNESS_APP_CODE',
            'PAYHERE_APP_SECRET',
            'PAYHERE_MERCHANT_ID',
            'GOOGLE_TAG_MANAGER_ID',
            'BKASH_PASSWORD',
            'BKASH_USER_NAME',
            'BKASH_APP_SECRET',
            'BKASH_APP_KEY',
            'COMPANY_TOKEN',
            'SERVICE_TYPE'
        ],

        '_POST' => [
            'password',
        ],
    ]

];
