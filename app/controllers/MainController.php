<?php

namespace App\controllers;

use App\models\UsersModel;
use Delight\Auth\Auth;
use League\Plates\Engine;
use League\Plates\Extension\Asset;

class MainController
{
    protected $templates;
    protected $auth;
    protected $user;

    public function __construct( Engine $templates, Auth $auth, UsersModel $user)
    {
        $this->templates = $templates;
        $templates->loadExtension(new Asset('./'));
        $this->auth = $auth;
        $this->user = $user;
    }
}