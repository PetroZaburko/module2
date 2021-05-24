<?php

use App\QueryBuilder;

$test = new QueryBuilder();
var_dump($test->insert([
    'name' => 'Petro',
    'position' => 'manager',
    'img' => 'avatar.png',
    'banned' => '0'
],'users'));