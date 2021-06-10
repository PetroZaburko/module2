<?php

namespace App\models;

use App\QueryBuilder;

class Model
{
    protected $qb;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->qb = $queryBuilder;
    }
}