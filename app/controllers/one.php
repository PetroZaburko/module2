<?php

use App\QueryBuilder;

$test = new QueryBuilder();
var_dump($test->one('5','users'));