<?php

use App\QueryBuilder;

$test = new QueryBuilder();
var_dump($test->update(5, [
    'name' => "Petro Zaburko",
    'activity' => 'PHP developer'
], 'users'));
