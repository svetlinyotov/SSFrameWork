<?php

namespace App\Controllers;


use SSFrame\Facades\View;

class HomeController
{
    public function index()
    {
        //View::appendToLayout('body', "auth.login");
        View::display('layouts.main');
    }
}