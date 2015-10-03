<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;
use SSFrame\Facades\Auth;

class Reviews extends SimpleDB
{
    public function getForProduct($product_id)
    {
        return $this->sql("SELECT
                                r.text,
                                r.stars,
                                u.email as `from`,
                                UNIX_TIMESTAMP(r.date) as time
                           FROM reviews as r
                           JOIN users as u ON u.id = r.user_id
                           WHERE r.product_id = ?
                           ORDER BY `time` DESC
                           ", [$product_id])->fetchAllAssoc();
    }

    public function getForUser($user_id, $product_id)
    {
        if($user_id != false) {
            return $this->sql("SELECT
                                r.text,
                                r.stars
                           FROM reviews as r
                           WHERE r.user_id = ? AND r.product_id = ?
                           ", [$user_id, $product_id])->fetchRowAssoc();
        }
    }

    public function hasCurrentUserReviewed($product_id)
    {
        if(Auth::user() !== false){
            return (bool)$this->sql("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?", [$product_id, Auth::user()->id])->getAffectedRows();
        }
        return false;
    }

    public function add($product_id, $user_id, $stars, $text)
    {
        $this->sql("INSERT INTO reviews (product_id, user_id, text, stars) VALUES (?,?,?,?)", [$product_id, $user_id, $text, $stars]);
    }
    public function update($product_id, $user_id, $stars, $text)
    {
        $this->sql("UPDATE reviews SET text=?, stars=?, date=NOW() WHERE product_id = ? AND user_id = ?", [$text, $stars, $product_id, $user_id]);
    }
}