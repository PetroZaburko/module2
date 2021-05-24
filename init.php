<?php

use App\Route;

Route::setActionsDir('../app/controllers/');
Route::set404File('404.php');
Route::get('')->path('homepage.php');
Route::get('all')->path('all.php');
Route::get('one')->path('one.php');
Route::get('insert')->path('insert.php');
Route::get('update')->path('update.php');
Route::get('delete')->path('delete.php');

Route::run();