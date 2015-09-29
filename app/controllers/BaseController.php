<?php

namespace App\Controllers;


use SSFrame\Sessions\Session;
use SSFrame\View;

class BaseController
{

    /**
     * @var View
     */
    public $view;
    /**
     * @var Session
     */
    public $session;

    public function __construct()
    {
        $this->view = View::getInstance();
        $this->session = Session::getInstance();
    }
}