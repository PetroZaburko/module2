<?php

use App\QueryBuilder;

$test = new QueryBuilder();
var_dump($test->all('users'));