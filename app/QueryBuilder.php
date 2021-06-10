<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    protected $pdo;
    protected $queryFactory;

    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }

    public function all($table,  $cols = ['*'])
    {
        $all = $this->queryFactory->newSelect();
        $all
            ->cols($cols)
            ->from($table);
        $stm = $this->pdo->prepare($all->getStatement());
        $stm->execute($all->getBindValues());
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allJoin($table, array $joinParams,  $cols = ['*'])
    {
        $all = $this->queryFactory->newSelect();
        $all
            ->cols($cols)
            ->from($table)
            ->join($joinParams[0], $joinParams[1], $joinParams[2]);
        $stm = $this->pdo->prepare($all->getStatement());
        $stm->execute($all->getBindValues());
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allWherePaging($table, $where, $page = null)
    {
        $allWhere = $this->queryFactory->newSelect();
        $allWhere
            ->cols(['*'])
            ->from($table)
            ->where($where)
            ->setPaging(Helpers::const('view.paging'))
            ->page($page ?? 1);
        $stm = $this->pdo->prepare($allWhere->getStatement());
        $stm->execute($allWhere->getBindValues());
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allJoinPaging($table, $page, array $joinParams,  $cols = ['*'])
    {
        $all = $this->queryFactory->newSelect();
        $all
            ->cols($cols)
            ->from($table)
            ->join($joinParams[0], $joinParams[1], $joinParams[2])
            ->orderBy(['id ASC'])
            ->setPaging(Helpers::const('view.paging'))
            ->page($page ?? 1);
        $stm = $this->pdo->prepare($all->getStatement());
        $stm->execute($all->getBindValues());
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function one($id, $table, $cols = ['*'])
    {
        $one = $this->queryFactory->newSelect();
        $one
            ->cols($cols)
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);
        $stm = $this->pdo->prepare($one->getStatement());
        $stm->execute($one->getBindValues());
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function oneJoin($id, $table, array $joinParams,  $cols = ['*'])
    {
        $oneJoin = $this->queryFactory->newSelect();
        $oneJoin
            ->cols($cols)
            ->from($table)
            ->join($joinParams[0], $joinParams[1], $joinParams[2])
            ->orderBy(['id ASC'])
            ->where('id = :id')
            ->bindValue('id', $id);
        $stm = $this->pdo->prepare($oneJoin->getStatement());
        $stm->execute($oneJoin->getBindValues());
        return $stm->fetch(PDO::FETCH_ASSOC);
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

    public function update($id, $values, $table, $idKey = 'id')
    {
        $update = $this->queryFactory->newUpdate();
        $update
            ->table($table)
            ->cols($values)
            ->where("$idKey = :$idKey")
            ->bindValue($idKey, $id);
        $stm = $this->pdo->prepare($update->getStatement());
        return $stm->execute($update->getBindValues());
    }

    public function delete($id, $table, $idKey = 'id')
    {
        $delete = $this->queryFactory->newDelete();
        $delete
            ->from($table)
            ->where("$idKey = :$idKey")
            ->bindValue($idKey, $id);
        $stm = $this->pdo->prepare($delete->getStatement());
        return $stm->execute($delete->getBindValues());
    }
}