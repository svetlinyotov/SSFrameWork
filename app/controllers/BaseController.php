<?php

namespace App\Controllers;


use SSFrame\View;

class BaseController
{

    /**
     * @var View
     */
    public $view;

    public function __construct()
    {
        $this->view = View::getInstance();
    }
}