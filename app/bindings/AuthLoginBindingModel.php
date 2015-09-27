<?php

namespace App\Bindings;


use SSFrame\BindingModel;

class AuthLoginBindingModel extends BindingModel
{
    public $email;
    public $password;
    public $remember;

    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRemember()
    {
        return $this->remember;
    }
}