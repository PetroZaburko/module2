<?php

use League\Plates\Engine;

$templates = new Engine('../app/views/templates');

echo $templates->render('view_home', [
    'title' => "Home page !!!"
]);