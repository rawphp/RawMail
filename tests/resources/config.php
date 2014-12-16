<?php

return
    [
        'from_email' => 'no-reply@rawphp.org',
        'from_name'  => 'RawPHP',
        'smtp'       =>
            [
                'auth'     => TRUE,
                'host'     => 'smtp.gmail.com',
                'username' => 'username',
                'password' => 'password',
                'security' => 'ssl',
                'port'     => 465,
            ]

    ];
