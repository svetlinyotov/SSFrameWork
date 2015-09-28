<?php

namespace SSFrame\Facades;


class Auth
{
    public static function make($username, $password, $remember = null)
    {
        return \SSFrame\Auth::getInstance()->make($username, $password, $remember);
    }
    public static function byId($id)
    {
        return \SSFrame\Auth::getInstance()->byId($id);
    }
    public static function doAuth(){
        return \SSFrame\Auth::getInstance()->doAuth();
    }

    public static function user()
    {
        return \SSFrame\Auth::getInstance()->user();
    }

    public static function logout()
    {
        return \SSFrame\Auth::getInstance()->logout();
    }
}