<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;

class Products extends SimpleDB
{
    public function listAllFromCat($cat_id)
    {
        return $this->sql("SELECT
                              p.id,
                              p.category_id,
                              p.name,
                              p.description,
                              p.price,
                              p.quantity,
                              p.photo,
                              COUNT(DISTINCT reviews.id) as total_reviews,
                              AVG(reviews.stars) as avg_stars
                            FROM products AS p
                            LEFT JOIN reviews ON reviews.product_id = p.id
                            WHERE p.category_id = ? AND is_available = 1 AND quantity > 0
                            GROUP BY reviews.product_id, p.id
                            ORDER BY p.position", [$cat_id])->fetchAllAssoc();
    }

    public function get($id)
    {
        return $this->sql("SELECT
                              p.id,
                              p.category_id,
                              p.name,
                              p.description,
                              p.price,
                              p.quantity,
                              p.photo,
                              COUNT(DISTINCT reviews.id) as total_reviews,
                              AVG(reviews.stars) as avg_stars
                            FROM products AS p
                            LEFT JOIN reviews ON reviews.product_id = p.id
                            WHERE p.id = ?
                            GROUP BY reviews.product_id", [$id])->fetchRowAssoc();
    }

    public function getName($id)
    {
        return $this->sql("SELECT name FROM products WHERE id = ?", [$id])->fetchRowAssoc()['name'];
    }

    public function checkQuantity($id)
    {
        return $this->sql("SELECT quantity FROM products WHERE id = ?", [$id])->fetchRowAssoc()['quantity'];
    }

    public function add($name, $description, $price, $quantity, $category, $photo)
    {
        return $this->sql("INSERT INTO products (name, description, price, quantity, category_id, photo) VALUES (?,?,?,?,?,?)", [$name, $description, $price, $quantity, $category, $photo]);
    }

    public function edit($id, $name, $description, $price, $quantity, $category, $photo = null)
    {
        if($photo != null) {
            return $this->sql("UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, category_id = ?, photo = ? WHERE id = ?", [$name, $description, $price, $quantity, $category, $photo, $id]);
        }
        return $this->sql("UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, category_id = ? WHERE id = ?", [$name, $description, $price, $quantity, $category, $id]);
    }

    public function delete($id)
    {
        return $this->sql("DELETE FROM products WHERE id = ?", [$id]);
    }

    public function updateSort($product_id, $position)
    {
        return $this->sql("UPDATE products SET `position` = ? WHERE id = ?", [$position, $product_id]);
    }


}