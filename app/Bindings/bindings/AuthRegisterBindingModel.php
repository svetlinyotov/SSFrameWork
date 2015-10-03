<?php

namespace App\Bindings;


use SSFrame\BindingModel;

class AuthRegisterBindingModel extends BindingModel
{
    public $email;
    public $password;
    public $repassword;
    public $names;
}