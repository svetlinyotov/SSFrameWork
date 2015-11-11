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
    /**
     * @var Redirect
     */
    public $redirect;
    /**
     * @var Validation
     */
    public $validation;
    /**
     * @var Auth
     */
    public $auth;

    public function __construct()
    {
        $this->view = View::getInstance();
        $this->session = Session::getInstance();
        $this->redirect = Redirect::getInstance();
        $this->validation = Validation::getInstance();
        $this->auth = Auth::getInstance();
    }
}