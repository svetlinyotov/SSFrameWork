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
                            left JOIN reviews ON reviews.product_id = p.id
                            WHERE p.category_id = ?
                            GROUP BY reviews.product_id", [$cat_id])->fetchAllAssoc();
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

}