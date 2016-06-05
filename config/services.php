<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('sandboxfe3a7fc8e5194b1ea45130424aa5b244.mailgun.org'),
        'secret' => env('key-33240f50add35c8f5bb2444cc74ef0dd'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id'     => '266439737035266',
        'client_secret' => 'ec0d7c8ff8724b2c17d5dfc7a5e8e33e',
        'scopes'        => ['email', 'user_birthday','user_about_me','user_education_history',
                            'user_location','user_work_history','user_hometown','user_likes'],
        'redirect'      => 'http://qanya.local:8000/auth/facebook/callback',
    ],

];
