<?php

namespace App\Areas\Admin\Models;


use SSFrame\DB\SimpleDB;

class Users extends SimpleDB
{

    public function listAll()
    {
        return $this->sql("SELECT * FROM users WHERE is_ban = 1 ORDER BY id DESC")->fetchAllAssoc();
    }

    public function add($email)
    {
        $this->sql("UPDATE users SET is_ban = 1 WHERE email = ?", [$email]);
    }

    public function delete($id)
    {
        $this->sql("UPDATE users SET is_ban = 0 WHERE id = ?", [$id]);
    }
}