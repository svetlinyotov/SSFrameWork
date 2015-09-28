<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;
use SSFrame\Facades\DB;
use SSFrame\Hash;

class User extends SimpleDB
{
    public static function create($email, $password, $names)
    {
        $password = Hash::make($password);

        DB::insert("INSERT INTO users (email, password, names) VALUES (?, ?, ?)", [$email, $password, $names]);
    }

}