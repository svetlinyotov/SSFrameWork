<?php

namespace App\Areas\Admin\Controllers;


use SSFrame\DefaultController;
use SSFrame\Facades\View;

class UsersController extends DefaultController
{
    public function index()
    {
        View::appendToLayout('body', "users");
        View::display('layouts.main');
    }


}