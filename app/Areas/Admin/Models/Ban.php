<?php

namespace App\Areas\Admin\Models;


use SSFrame\DB\SimpleDB;

class Ban extends SimpleDB
{

    public function listAll()
    {
        return $this->sql("SELECT * FROM ban_ip ORDER BY id DESC")->fetchAllAssoc();
    }

    public function add($ip)
    {
        $this->sql("INSERT INTO ban_ip (ip) VALUES (?)", [$ip]);
    }

    public function delete($id)
    {
        $this->sql("DELETE FROM ban_ip WHERE id = ?", [$id]);
    }
}