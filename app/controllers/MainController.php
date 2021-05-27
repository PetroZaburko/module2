<?php


namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;

class MainController
{
    protected $db;
    protected $templates;

    public function __construct()
    {
        $this->db = new QueryBuilder();
        $this->templates = new Engine('../app/views/templates');
    }

}