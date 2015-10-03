<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;
use SSFrame\Facades\Auth;

class Cart extends SimpleDB
{
    public function listProducts($data)
    {
        if(is_array($data)) {
            $promotions = new Promotions();
            $product_ids = implode(",", array_keys($data));
            $query = $this->sql("SELECT products.id, products.name as product_name, products.photo as product_photo, price, categories.name as category_name, category_id FROM products JOIN categories ON categories.id = products.category_id WHERE products.id IN ($product_ids)")->fetchAllAssoc();
            foreach ($query as $key => $item) {
                $discount = $promotions->getProductPromotion($item['id']);
                if($discount){
                    $query[$key]['discount'] = $discount;
                }
            }

            return $query;

        }
    }

    public function checkout($names, $email, $mobile, $address)
    {
        return $this->sql("INSERT INTO checkouts (user_id, email, `names`, mobile, address) VALUES (?,?,?,?,?)", [Auth::user()->id, $email, $names, $mobile, $address])->getLastInsertId();
    }

}