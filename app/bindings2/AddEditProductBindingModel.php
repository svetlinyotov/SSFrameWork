<?php

namespace App\Bindings;


use SSFrame\BindingModel;

class AddEditProductBindingModel extends BindingModel
{
    public $title, $description, $price, $quantity, $category, $photo;
}