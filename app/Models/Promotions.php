<?php

namespace App\Models;


use SSFrame\DB\SimpleDB;

class Promotions extends SimpleDB
{
    public function getProductPromotion($id)
    {
        $query = $this->sql("SELECT
                     MAX(max_promo_all) AS max_promo_all,
                     MAX(max_promo_cat) AS max_promo_cat,
                     MAX(max_promo_prod) AS max_promo_prod
                    FROM products AS p
                    LEFT JOIN
                        (SELECT
                            promotion AS max_promo_prod,
                            product_id
                        FROM promotions_products
                        WHERE CURRENT_DATE BETWEEN date_start AND date_end
                        ) prod_promotion ON prod_promotion.product_id = p.id
                    LEFT JOIN
                        (SELECT
                            promotion AS max_promo_cat,
                            category_id
                        FROM promotions_categories
                        WHERE CURRENT_DATE BETWEEN date_start AND date_end
                        ) cat_promotion ON cat_promotion.category_id = p.category_id
                    LEFT JOIN
                        (SELECT
                            promotion AS max_promo_all
                        FROM promotions_all
                        WHERE CURRENT_DATE BETWEEN date_start AND date_end
                        ) all_promotion ON all_promotion.max_promo_all > 0

                    WHERE p.id = ?
                    ", [$id])->fetchRowAssoc();

        return (int)max($query);
    }

}