<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;

class Cart extends SimpleDB
{
    public function listProducts($data)
    {
        if(is_array($data)) {
            $product_ids = implode(",", array_keys($data));
            return $this->sql("SELECT products.id, products.name as product_name, products.photo as product_photo, price, categories.name as category_name, category_id FROM products JOIN categories ON categories.id = products.category_id WHERE products.id IN ($product_ids)")->fetchAllAssoc();
        }
    }

}