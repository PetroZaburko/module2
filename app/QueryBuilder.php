<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private $pdo;
    private $queryFactory;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=marlin_test', 'root', 'asdfg001');
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function all($table)
    {
        $all = $this->queryFactory->newSelect();
        $all
            ->cols(['*'])
            ->from($table);
        $stm = $this->pdo->prepare($all->getStatement());
        $stm->execute($all->getBindValues());
        return $stm->fetchAll(PDO::FETCH_ASSOC);

    }

    public function one($id, $table)
    {
        $one = $this->queryFactory->newSelect();
        $one
            ->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);
        $stm = $this->pdo->prepare($one->getStatement());
        $stm->execute($one->getBindValues());
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($values, $table)
    {
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)
            ->cols($values);
        $stm = $this->pdo->prepare($insert->getStatement());
        return $stm->execute($insert->getBindValues());
    }

    public function update($id, $values, $table)
    {
        $update = $this->queryFactory->newUpdate();
        $update
            ->table($table)
            ->cols($values)
            ->where('id = :id')
            ->bindValue('id', $id);
        $stm = $this->pdo->prepare($update->getStatement());
        return $stm->execute($update->getBindValues());
    }

    public function delete($id, $table)
    {
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);
        $stm = $this->pdo->prepare($delete->getStatement());
        return $stm->execute($delete->getBindValues());
    }

}