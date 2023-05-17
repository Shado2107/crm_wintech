<?php
return [
  
    'driver' => env('MAIL_DRIVER'),

    'host' => env('MAILJET_APIKEY'),

    'host' => env('in-v3.mailjet.com'),

    'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'info@sicot-bf.com'),
        'name' => env('MAIL_FROM_NAME', 'Todje'),
    ],

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),

    'mailers' => [

        'mailjet' => [
            'transport' => 'mailjet',
        ]
    ]
];
