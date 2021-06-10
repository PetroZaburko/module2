<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;
use PDO;

class Container
{
    protected static $container;

    public static function container()
    {
        if (self::$container == null) {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->addDefinitions([
                Engine::class => function () {
                    return new Engine('../app/views/templates');
                },
                PDO::class => function () {
                    return new PDO(
                        "mysql:host=" . Helpers::const('mysql.host') . ";dbname=" . Helpers::const('mysql.database'),
                        Helpers::const('mysql.username'),
                        Helpers::const('mysql.password'));
                },
                Auth::class => function ($container) {
                    return new Auth($container->get('PDO'));
                },
                QueryFactory::class => function () {
                    return new QueryFactory('mysql');
                }
            ]);
            self::$container =  $containerBuilder->build();
        }
        return self::$container;
    }
}