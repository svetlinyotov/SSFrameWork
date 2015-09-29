<?php

namespace App\Controllers\Products;


use App\Controllers\BaseController;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Reviews;
use SSFrame\Facades\Auth;

class ProductsController extends BaseController
{
    /**
     * @param \App\Models\Products $products
     * @param \App\Models\Categories $categories
     * @throws \Exception
     */
    public function listAll($id, Products $products, Categories $categories)
    {
        $this->view->appendToLayout('body', "products.products");
        $this->view->display('layouts.main', ['data'=>$products->listAllFromCat($id), 'categories'=>$categories->listAllNames()]);
    }

    /**
     * @param \App\Models\Products $products
     * @param \App\Models\Reviews $reviews
     * @param \App\Models\Categories $categories
     * @throws \Exception
     */
    public function getProduct($id, Products $products, Reviews $reviews, Categories $categories)
    {
        $this->view->appendToLayout('body', "products.product");

        //echo "<pre>".print_r($reviews->getForProduct($id),true)."</pre>";
        $this->view->display('layouts.main', ['product'=>$products->get($id), 'reviews'=>$reviews->getForProduct($id), 'current_user_review' => $reviews->getForUser(Auth::user()->id, $id),'categories'=>$categories->listAllNames()]);
    }



}