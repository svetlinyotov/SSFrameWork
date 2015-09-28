<?php

namespace SSFrame\Facades;


use SSFrame\DB\SimpleDB;

class DB
{
    public static function insert($sql, $params=[], $options=[])
    {
        $db = new SimpleDB();
        return $db->sql($sql, $params, $options);
    }

}