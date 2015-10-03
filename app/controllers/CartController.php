<?php

namespace App\Controllers;


use app\bindings\CheckOutBindingModel;
use App\Bindings\UpdateCartBindingModel;
use App\Models\Cart;
use App\Models\Products;
use SSFrame\Facades\Auth;
use SSFrame\Facades\Redirect;
use SSFrame\Facades\Validation;
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

        View::appendToLayout('body', "cart.cart");
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

    public function delete($id)
    {
        $temp = $this->session->getSession()->cart;
        unset ($temp[$id]);

        $this->session->getSession()->cart = $temp;
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

    /**
     * @Authorized('/login')
     * @param \App\Models\Cart $cart
     */
    public function checkout(Cart $cart)
    {
        $list = $cart->listProducts($this->session->getSession()->cart);

        View::appendToLayout('body', "cart.checkout");
        View::display('layouts.main', ['items' => $list, 'session_cart' => $this->session->getSession()->cart]);
    }

    /**
     * @Authorized('/login')
     * @param \App\Bindings\CheckOutBindingModel $input
     * @param \App\Models\Cart $cart
     */
    public function doCheckout(CheckOutBindingModel $input, Cart $cart)
    {
        Validation::validate($input, [
            'names' => 'required|min:5',
            'email' => 'required|min:5|email',
            'mobile' => 'required',
            'address' => 'required',
        ]);

        if(Validation::getErrors() == false){
            $cart->checkout($input->names, $input->email, $input->mobile, $input->address);
            $this->emptyCart();
            return Redirect::to('/products')->withSuccess("You have sent your order successfully.")->go();
        }

        Redirect::to('/cart/checkout')->withErrors(Validation::getErrors())->withInput($input)->go();
    }

}