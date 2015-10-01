<?php

namespace App\Areas\Admin\Controllers;


use SSFrame\DefaultController;
use SSFrame\Facades\View;

class AdminController extends DefaultController
{
    public function index()
    {
        View::appendToLayout('body', "users");
        View::display('layouts.main');
    }

    public function banIndex()
    {
        View::appendToLayout('body', "ban");
        View::display('layouts.main');
    }

}