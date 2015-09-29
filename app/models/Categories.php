<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;

class Categories extends SimpleDB
{
    public function listAll()
    {
        return $this->sql("SELECT * FROM categories")->fetchAllAssoc();
    }
    public function listAllNames()
    {
        return $this->sql("SELECT id, name FROM categories")->fetchAllAssoc();
    }
}