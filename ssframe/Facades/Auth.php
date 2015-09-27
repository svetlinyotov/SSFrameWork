<?php

namespace SSFrame\Facades;


class Auth
{
    public static function make($username, $password, $remember = null)
    {
        return \SSFrame\Auth::getInstance()->make($username, $password, $remember);
    }
}