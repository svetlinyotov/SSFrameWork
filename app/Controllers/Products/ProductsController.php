<?php

namespace App\Controllers\Products;


use App\Bindings\AddEditProductBindingModel;
use App\Bindings\SortProductsBindingModel;
use App\Controllers\BaseController;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Promotions;
use App\Models\Reviews;
use SSFrame\Files\FileUpload;

class ProductsController extends BaseController
{
    /**
     * @param $id
     * @param Products $products
     * @param Categories $categories
     * @throws \Exception
     */
    public function listAll($id, Products $products, Categories $categories)
    {
        $cart = $this->session->getSession()->cart?:[''];
        $this->view->appendToLayout('body', "products.products");
        //echo "<pre>".print_r($products->listAllFromCat($id),true)."</pre>";return;
        $this->view->display('layouts.main', ['data'=>$products->listAllFromCat($id), 'cart' => $cart, 'categories'=>$categories->listAllNames(), 'currentCategory' => $id]);
    }

    /**
     * @param $id
     * @param Products $products
     * @param Reviews $reviews
     * @param Categories $categories
     * @param Promotions $promotions
     * @throws \Exception
     */
    public function getProduct($id, Products $products, Reviews $reviews, Categories $categories, Promotions $promotions)
    {
        $cart = $this->session->getSession()->cart?:[''];

        $this->view->appendToLayout('body', "products.product");

        $this->view->display('layouts.main', ['product'=>$products->get($id), 'cart' => $cart, 'promotion'=>$promotions->getProductPromotion($id)?:null, 'reviews'=>$reviews->getForProduct($id), 'current_user_review' => $reviews->getForUser($this->auth->user()->id, $id),'categories'=>$categories->listAllNames()]);
    }


    /**
     * @Authorized('/login')
     * @UserRole(0,1)
     * @param AddEditProductBindingModel $input
     * @param Products $product
     */
    public function add(AddEditProductBindingModel $input, Products $product)
    {
        $file_name = time().rand(100,999);
        $file = FileUpload::postImage($_FILES['photo'], $file_name, __DIR__.'/../../../public/user_data/products', false, 300);
        $product->add($input->title, $input->description, $input->price, $input->quantity, $input->category, $file);
        $this->redirect->back()->go();
    }

    /**
     * @param $id
     * @param AddEditProductBindingModel $input
     * @param Products $product
     * @Authorized
     * @UserRole(0)
     */
    public function edit($id, AddEditProductBindingModel $input, Products $product)
    {
        $file = null;
        if($_FILES['photo']['name'] != "") {
            $file_name = time() . rand(100, 999);
            $file = FileUpload::postImage($_FILES['photo'], $file_name, __DIR__ . '/../../../public/user_data/products', false, 300);
        }

        $product->edit($id, $input->title, $input->description, $input->price, $input->quantity, $input->category, $file);
        $this->redirect->back()->go();
    }

    /**
     * @param $id
     * @param Products $product
     * @Authorized
     * @UserRole(0,1)
     */
    public function delete($id, Products $product)
    {
        $product->delete($id);
        $this->redirect->back()->go();
    }

    /**
     * @Authorized
     * @UserRole(0,1)
     * @param SortProductsBindingModel $input
     * @param Products $product
     */
    public function sort(SortProductsBindingModel $input, Products $product)
    {
        foreach($input->getProduct() as $position=>$product_id) {
            $product->updateSort($product_id, $position);
        }
    }


}