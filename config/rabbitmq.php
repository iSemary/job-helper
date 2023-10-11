<?php

return [
    'default' => env('RABBITMQ_CONNECTION', 'default'),

    'connections' => [

        'default' => [
            'url' => env('RABBITMQ_URL', 'amqp://localhost'),
            'host' => env('RABBITMQ_HOST', 'localhost'),
            'port' => env('RABBITMQ_PORT', 5672),
            'user' => env('RABBITMQ_USER', 'guest'),
            'password' => env('RABBITMQ_PASSWORD', 'guest'),
            'vhost' => env('RABBITMQ_VHOST', '/'),
        ],

    ],

    'queue' => env('RABBITMQ_QUEUE', 'default'),

    'workers' => env('RABBITMQ_WORKERS', 1),

];
