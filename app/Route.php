<?php

namespace App;

class Route
{
    protected $action, $route, $path;

    protected static $basePath;
    protected static $actionsDir = '../';
    protected static $file404 = '404.php';
    protected static $routes = [];

    protected function __construct($action, $route) {
        $this->action = $action;
        $this->route = $route;
    }

    /**
     * Add route params to array $routes
     */
    protected function add() {
        self::$routes[$this->action][] = [
            'route' => $this->route,
            'path' => $this->path
        ];
    }

    /**
     * Prepare GET route params
     * @param $route        url route
     * @return self
     */
    public static function get($route) {
        return new self('GET',$route);
    }

    /**
     * Prepare POST route params
     * @param $route        url route
     * @return self
     */
    public static function post($route) {
        return new self('POST',$route);
    }

    /**
     * Add path/action to previously specified route
     * @param $path         action file
     */
    public function path($path) {
        $this->path = $path;
        $this->add();
    }

    /**
     * Run router to execute
     */
    public static function run() {
//        var_dump(self::$routes);die();
        $requestMethod = self::getRequestMethod();
        if (isset(self::$routes[$requestMethod])) {
            self::routeHandler(self::$routes[$requestMethod]);
        }
    }

    /**
     * Check if current route is in array $routes.
     * Redirect to specified path, if is in array $route, else redirect to  $file404
     * @param $routes
     */
    protected static function routeHandler($routes) {
        $url = self::getCurrentUrl();
        foreach ($routes as $route) {
            if ($route['route'] == $url) {
                $file = self::$actionsDir . $route['path'];
                if (file_exists($file)) {
                    include_once $file;
                    exit();
                }
            }
        }
        include_once self::$actionsDir . self::$file404;
    }

    /**
     * Return current request method (get or post)
     * @return string
     */
    protected static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Return current URL without base URL
     * @return string
     */
    protected static function getCurrentUrl() {
        $uri = reset(explode('?', $_SERVER["REQUEST_URI"]));
        $requestedUrl = urldecode(rtrim($uri, '/'));
        return substr($requestedUrl,strlen(self::getBasePath()));
    }

    /**
     * Return base URL
     * @return string
     */
    public static function getBasePath() {
        if (self::$basePath == null) {
            self::$basePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }
        return self::$basePath;
    }

    /**
     * Set dir location with actions files
     * @param $dir          dir location
     */
    public static function setActionsDir($dir) {
        self::$actionsDir = $dir;
    }

    /**
     * Set 404 file location
     * @param $file
     */
    public static function set404File($file) {
        self::$file404 = $file;
    }
}