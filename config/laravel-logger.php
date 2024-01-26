<?php

return [
    'active' => env('LOGGER_ACTIVE', true),
    'log_events' => [
        'on_create' => true,
        'on_update' => true,
        'on_delete' => true,
    ],
    'auto_delete' => [
        'active' => env('LOGGER_AUTO_DELETE', false),
        'delete_day' => env('LOGGER_DELETE_DAY', 30),
    ],
];
