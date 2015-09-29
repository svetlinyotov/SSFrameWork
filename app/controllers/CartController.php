<?php

namespace App\Controllers;


use App\Bindings\UpdateCartBindingModel;
use App\Models\Cart;
use App\Models\Products;
use SSFrame\Facades\Redirect;
use SSFrame\Facades\View;

class CartController extends BaseController
{
    private $cart_session = null;

    public function __construct(){
        parent::__construct();
        $this->cart_session = $this->session->getSession()->cart;
    }
    /**
     * @param \App\Models\Cart $cart
     */
    public function index(Cart $cart)
    {
        $list = $cart->listProducts($this->session->getSession()->cart);

        View::appendToLayout('body', "cart");
        View::display('layouts.main', ['items' => $list, 'session_cart' => $this->session->getSession()->cart]);
    }

    /**
     * @param $product_id
     * @param \App\Models\Products $product
     */
    public function add($product_id, Products $product)
    {


        if (!is_array($this->cart_session)) {
            $this->session->getSession()->cart = [$product_id => 1];
        } else {
            if ($product->checkQuantity($product_id) >= $this->cart_session[$product_id] + 1) {
                $this->cart_session[$product_id]++;
                $this->session->getSession()->cart = $this->cart_session;
            }
        }

        Redirect::to("back")->go();
    }

    /**
     * @param \App\Bindings\UpdateCartBindingModel $input
     * @param \App\Models\Products $product
     */
    public function update(UpdateCartBindingModel $input, Products $product)
    {
        $errors = [];
        foreach ($input->getQuantity() as $product_id => $item) {
            $check = $product->checkQuantity($product_id);
            if ($check < $item) {
                array_push($errors, "Product <b>".$product->getName($product_id)."</b> has max quantity: $check");
            }
        }

        if(count($errors) > 0) {
            Redirect::to('/cart')->withErrors($errors)->go();
        }else {
            $this->session->getSession()->cart = $input->getQuantity();
        }
        Redirect::to('/cart')->go();
    }

    public function emptyCart()
    {
        $this->session->getSession()->unsetKey('cart');
        Redirect::to('/cart')->go();
    }

}