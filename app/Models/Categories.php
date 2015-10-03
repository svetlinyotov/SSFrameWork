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

    public function add($name, $description, $photo)
    {
        return $this->sql("INSERT INTO categories (name, description, photo) VALUES (?,?,?)", [$name, $description, $photo]);
    }

    public function edit($id, $name, $description, $photo = null)
    {
        if($photo != null) {
            return $this->sql("UPDATE categories SET name = ?, description = ?, photo = ? WHERE id = ?", [$name, $description, $photo, $id]);
        }
        return $this->sql("UPDATE categories SET name = ?, description = ? WHERE id = ?", [$name, $description, $id]);
    }

    public function delete($id)
    {
        return $this->sql("DELETE FROM categories WHERE id = ?", [$id]);
    }
}