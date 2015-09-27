<?php

namespace SSFrame\Facades;


class View
{
    public static function setViewDirectory($path)
    {
        \SSFrame\View::getInstance()->setViewDirectory($path);
    }

    public static function display($name)
    {
        return \SSFrame\View::getInstance()->display($name);
    }

    public static function getLayoutData($name)
    {
        return \SSFrame\View::getInstance()->getLayoutData($name);
    }

    public static function appendToLayout($key, $template)
    {
        \SSFrame\View::getInstance()->appendToLayout($key, $template);
    }
}