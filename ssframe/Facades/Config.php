<?php

namespace SSFrame\Facades;


class Config
{

    public static function get($name)
    {
        return \SSFrame\Config::getInstance()->get($name);
    }
    public static function setConfigFolder($folder)
    {
        return \SSFrame\Config::getInstance()->setConfigFolder($folder);
    }

}