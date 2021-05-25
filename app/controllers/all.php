<?php

use App\QueryBuilder;
use League\Plates\Engine;

$db = new QueryBuilder();
$users = $db->all('users');
$templates = new Engine('../app/views/templates');

echo $templates->render('users/view_all', [
    'users' => $users,
    'title' => 'All users'
]);