<?php

use App\QueryBuilder;
use League\Plates\Engine;

$db = new QueryBuilder();
$id = $_GET['id'];
$user = $db->one($id,'users');
$templates = new Engine('../app/views/templates');

echo $templates->render('users/view_one', [
    'user' => $user,
    'title' => "Info about user " . $user['name']
]);