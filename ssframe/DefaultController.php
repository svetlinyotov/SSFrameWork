<?php

namespace SSFrame;


use SSFrame\Sessions\Session;

class DefaultController
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