<?php

//use App\Route;
//
//Route::setActionsDir('../app/controllers/');
//Route::set404File('404.php');
//Route::get('')->path('homepage.php');
//Route::get('all')->path('all.php');
//Route::get('one')->path('one.php');
//Route::get('insert')->path('insert.php');
//Route::get('update')->path('update.php');
//Route::get('delete')->path('delete.php');
//
//Route::run();



$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    $r->addRoute('GET', '', ['App\controllers\HomeController', 'index']);
    $r->addRoute('GET', 'users/all', ['App\controllers\UsersController', 'all']);
    $r->addRoute('GET', 'users/one/{id:\d+}', ['App\controllers\UsersController', 'one']);

    $r->addRoute('POST', 'users/add', ['App\controllers\UsersController', 'add']);
    $r->addRoute('POST', 'users/update/{id:\d+}', ['App\controllers\UsersController', 'update']);
    $r->addRoute('GET', 'users/delete/{id:\d+}', ['App\controllers\UsersController', 'delete']);



    $r->addRoute('GET', '/users', 'get_all_users_handler');
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$basePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = substr(rawurldecode($uri), strlen($basePath));

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo 404;
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func([new $handler[0], $handler[1]], $vars);
        // ... call $handler with $vars
        break;
}