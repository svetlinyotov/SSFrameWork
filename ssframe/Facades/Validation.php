<?php

namespace SSFrame\Facades;


class Validation
{
    public static function validate($params, $data)
    {
        return \SSFrame\Validation::getInstance()->validate($params, $data);
    }
    public static function getErrors()
    {
        return \SSFrame\Validation::getInstance()->getErrors();
    }

}