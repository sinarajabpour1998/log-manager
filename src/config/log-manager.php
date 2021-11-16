<?php

return [

    // set custom permission names for menus and routes
    // all permissions (except for menu) must be start with [permission:] keyword
    'permissions' => [
        'main' => 'permission:log-manager',
        'all-logs' => 'permission:log-manager-all',
        'error-logs' => 'permission:log-manager-errors',
        'sms-logs' => 'permission:log-manager-sms',
        'show-error-log' => 'permission:log-manager-show-error',
        'delete-error-log' => 'permission:log-manager-delete-error',
        'menu' => [
            'main' => 'log-manager',
            'all-logs' => 'log-manager-all',
            'error-logs' => 'log-manager-errors',
            'sms-logs' => 'log-manager-sms',
        ]
    ],
    // set log types, each type has a default title ex. "type" => "description"
    "log_types" => [
        "login" => "ورود به سایت",
        "registration" => "ثبت نام در سایت"
    ],

    // enable or disable sms logs
    "sms_logs" => "enable",

    // if sms_logs enabled, you should specify the sms log table model class
    "sms_log_model" => \Sinarajabpour1998\Notifier\Models\NotifierSmsLog::class
];
