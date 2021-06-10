<?php

use App\Auth;
use App\Container;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', 'verify_email', ['App\controllers\AuthController', 'verifyEmail']);

    $r->addRoute('GET', 'logout', ['App\controllers\AuthController', 'logout']);
    $r->addRoute('GET', 'login', ['App\controllers\AuthController', 'loginForm']);
    $r->addRoute('POST', 'login', ['App\controllers\AuthController', 'login']);

    $r->addRoute('GET', 'register', ['App\controllers\AuthController', 'registerForm']);
    $r->addRoute('POST', 'register', ['App\controllers\AuthController', 'register']);

    if (Auth::userIsLoggedIn()) {

    $r->addRoute('GET', 'users[/{page:\d+}]', ['App\controllers\UsersController', 'all']);
    $r->addRoute('GET', 'user/profile', ['App\controllers\UsersController', 'one']);

        if (Auth::userIsAdmin() ||
            $_GET['id'] == Auth::userID() ||
            $_POST['id'] == Auth::userID() ||
            $_POST['user_id'] == Auth::userID()) {

                $r->addRoute('GET', 'user/edit', ['App\controllers\UsersController', 'editInfo']);
                $r->addRoute('POST', 'user/edit', ['App\controllers\UsersController', 'updateInfo']);

                $r->addRoute('GET', 'user/password', ['App\controllers\UsersController', 'editPassword']);
                $r->addRoute('POST', 'user/password', ['App\controllers\UsersController', 'updatePassword']);

                $r->addRoute('GET', 'user/status', ['App\controllers\UsersController', 'editStatus']);
                $r->addRoute('POST', 'user/status', ['App\controllers\UsersController', 'updateStatus']);

                $r->addRoute('GET', 'user/media', ['App\controllers\UsersController', 'editMedia']);
                $r->addRoute('POST', 'user/media', ['App\controllers\UsersController', 'updateMedia']);

                $r->addRoute('GET', 'user/create', ['App\controllers\UsersController', 'create']);
                $r->addRoute('POST', 'user/create', ['App\controllers\UsersController', 'store']);

                $r->addRoute('GET', 'user/delete', ['App\controllers\UsersController', 'delete']);

                if ($_GET['id'] == Auth::userID() ||
                    $_POST['id'] == Auth::userID() ||
                    $_POST['user_id'] == Auth::userID()) {

                    $r->addRoute('GET', 'user/email', ['App\controllers\UsersController', 'editEmail']);
                    $r->addRoute('POST', 'user/email', ['App\controllers\UsersController', 'updateEmail']);
                }
        }
    }
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
        echo "404. This page does not exist? or you do not have permission";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        Container::container()->call($handler, [$vars]);
        break;
}