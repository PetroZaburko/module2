<?php


namespace App\controllers;

class HomeController extends MainController
{
    public function index()
    {
        echo $this->templates->render('view_home', [
            'title' => "Home page !!!"
        ]);
    }

}