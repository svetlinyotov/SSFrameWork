<?php

namespace App\Controllers;


class HomeController extends BaseController
{
    public function index()
    {
        //View::appendToLayout('body', "auth.login");
        $this->view->display('layouts.main');
    }
}