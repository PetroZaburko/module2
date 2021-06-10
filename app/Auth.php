<?php

namespace App;

class Auth
{
    protected static $auth;

    protected static function Auth()
    {
        if (self::$auth == null) {
            self::$auth = Container::container()->get('Delight\Auth\Auth');
        }
        return self::$auth;
    }

    public static function userID()
    {
        return self::Auth()->getUserId();
    }

    public static function userIsAdmin()
    {
        return self::Auth()->hasRole(\Delight\Auth\Role::ADMIN);
    }

    public static function userIsLoggedIn()
    {
        return self::Auth()->isLoggedIn();
    }

    public static function userName()
    {
        return self::Auth()->getUsername();
    }
}