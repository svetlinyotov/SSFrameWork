<?php

namespace App\Bindings;


use SSFrame\BindingModel;

class UserBindingModel extends BindingModel
{
    public function __construct(){

    }
    public $name;
    public $age;
    public $other;

    public function getName()
    {
        return $this->name;
    }
}