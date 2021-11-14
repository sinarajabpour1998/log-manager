<?php

return [

    // set custom permission names for menus and routes
    // all permissions (except for menu) must be start with [permission:] keyword
    'permissions' => [
        'main' => 'permission:log-manager',
        'menu' => [
            'main' => 'log-manager',
        ]
    ],
    'encryption' => [
        'mobile_encryption' => true,
        'email_encryption' => true,
    ]
];
