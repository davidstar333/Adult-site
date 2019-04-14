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
          'domain' => env('MAILGUN_DOMAIN'),
          'secret' => env('MAILGUN_SECRET'),
      ],
      'mandrill' => [
          'secret' => env('MANDRILL_SECRET'),
      ],
      'sparkpost' => [
          'secret' => env('SPARKPOST_SECRET'),
      ],
      'ses' => [
          'key' => env('SES_KEY'),
          'secret' => env('SES_SECRET'),
          'region' => 'us-east-1',
      ],
      'stripe' => [
          'model' => App\User::class,
          'key' => env('STRIPE_KEY'),
          'secret' => env('STRIPE_SECRET'),
      ],
      'facebook' => [
          'client_id' => env('FB_CLIENT_ID'),//'1142973889122904',
          'client_secret' => env('FB_CLIENT_SECRET'), //'f4870ac8b70eed6a3f27db090f2306a7',
          'redirect' => env('FB_REDIRECT_URL'), //'https://xcams.dev/login/facebook',
      ],
//AIzaSyCEUDH2YNyMKkb5wPfG1EKLO8C4vZr50Fs
      'google' => [
          'client_id' => env('GOOGLE_CLIENT_ID'), //'657628801608-3vl8j4h55ahpl5assk6bn5aua86mmdjk.apps.googleusercontent.com',
          'client_secret' => env('GOOGLE_CLIENT_SECRET'), //kthlssVwJs-UWTz2L-CBBY4W',
          'redirect' => env('GOOGLE_REDIRECT_URL'), //'https://xcams.dev/login/google',
      ],
      'twitter' => [
          'client_id' => env('TW_CLIENT_ID'), //'UIZyKgzZ5ekmU6yTp2CrDvTZa',
          'client_secret' => env('TW_CLIENT_SECRET'), //'O9G9DtnR1D7NLndjMSRlvAB9j7mHNNnJdfIbkvKpa56aSTqrpK',
          'redirect' => env('TW_REDIRECT_URL'), //'https://xcams.dev/login/twitter',
      ],
  ];
