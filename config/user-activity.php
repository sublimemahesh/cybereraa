<?php

return [
    'activated' => true, // active/inactive all logging
    'middleware' => ['web', 'auth', 'role:super_admin'],
    'route_path' => 'super-admin/user-activity',
    'admin_panel_path' => 'super-admin/dashboard',
    'delete_limit' => 30, // default 7 days

    'model' => [
        'user' => \App\Models\User::class
    ],

    'exclude_tables' => [
        'failed_jobs',
        'password_resets',
        'migrations',
        'logs',
        'personal_access_tokens',
        'sessions',
        'team_invitations',
        'team_user',
        'teams',
        'model_has_roles',
        'model_has_permissions',
        'role_has_permissions',
    ],

    'log_events' => [
        'on_create' => true,
        'on_edit' => true,
        'on_delete' => true,
        'on_login' => true,
        'on_lockout' => true
    ]
];
