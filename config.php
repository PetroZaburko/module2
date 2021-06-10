<?php

$GLOBALS['config'] = [
    'mysql' =>  [
        'host'  =>  'localhost',
        'username'  =>  'root',
        'password'  =>  'asdfg001',
        'database'  =>  'module2',
    ],
    'view' => [
        'paging' => '2'
    ],
    'cookie'    =>  [
        'cookie_name'   =>  'hash',
        'cookie_expiry' =>  604800
    ],
    'url' => [
        'path' => implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)). '/',
        'img' => 'img/demo/avatars/'
    ],
    'socialLinks' => [
        'vk' => 'https://www.vk.com/',
        'telegram' => 'https://www.telegram.com/@',
        'instagram' => 'https://www.instagram.com/'
    ],
    'email' => [
        'sender' =>'test@project@mail.com'
    ]
];