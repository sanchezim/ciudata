<?php

return [
    'USER_LOGIN_ATTEMPTS' => env('USER_LOGIN_ATTEMPTS', 3),
    'SPA_URL'             => env('SPA_URL', 'localhost'),
    'ROLES'               => ['master', 'senior', 'junior'],
    'PERMISSIONS'         => ['alta', 'consulta', 'actualiza', 'elimina'],
];
