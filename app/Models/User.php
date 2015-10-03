<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;
use SSFrame\Facades\Auth;
use SSFrame\Facades\DB;
use SSFrame\Hash;

class User extends SimpleDB
{
    public function create($email, $password, $names)
    {
        $password = Hash::make($password);

        $last_id = $this->sql("INSERT INTO users (email, password, names) VALUES (?, ?, ?)", [$email, $password, $names])->getLastInsertId();

        Auth::byId($last_id);
    }

}