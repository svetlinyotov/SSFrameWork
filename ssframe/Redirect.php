<?php

namespace SSFrame;


use SSFrame\Sessions\Session;

class Redirect
{
    public static $_instance = null;
    private $_path;
    private $_errors;
    private $_success;
    private $_input;
    private $session;

    public function __construct()
    {
        $this->session = Session::getInstance()->getSession();
    }

    public function to($path)
    {
        $this->_path = $path;

        if($path == "back") {
            $this->_path = $_SERVER['HTTP_REFERER'];
        }
        return $this;
    }
    public function withErrors($errors)
    {
        $this->_errors = (array)$errors;
        return $this;
    }
    public function withSuccess($success)
    {
        $this->_success = (array)$success;
        return $this;
    }
    public function withInput($input)
    {
        $this->_input = (array)$input;
        return $this;
    }

    public function go()
    {
        $this->session->unsetKey('withErrors');
        $this->session->unsetKey('withSuccess');
        $this->session->unsetKey('withInput');

        $this->session->withErrors = $this->_errors;
        $this->session->withSuccess = $this->_success;
        $this->session->withInput = $this->_input;

        header("Location: ".$this->_path);
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Redirect();
        }
        return self::$_instance;
    }

}