<?php

use App\QueryBuilder;

$test = new QueryBuilder();
var_dump($test->delete(5,'users'));
