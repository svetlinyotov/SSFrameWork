<?php

namespace App\Areas\Admin\Controllers;


use SSFrame\DefaultController;
use SSFrame\Facades\View;

class AdminController extends DefaultController
{
    public function index()
    {
        //View::appendToLayout('body', "auth.login");
        View::display('layouts.main');
    }

}