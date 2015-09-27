<?php

namespace SSFrame;


use SSFrame\Sessions\Session;

class CSRF
{
    public static $_instance = null;
    private $_session = null;
    private $_input = null;

    public function __construct()
    {
        $this->_session = Session::getInstance();
        $this->_input = InputData::getInstance();
    }

    public function generate()
    {
        $token = Common::generateToken();
        if(!is_string($this->_session->getSession()->XSRF_TOKEN)) {
            $this->_session->getSession()->XSRF_TOKEN = $token;
        }
    }

    public function token()
    {
        return $this->_session->getSession()->XSRF_TOKEN;
    }

    public function check()
    {
        $allPost = $this->_input->postAll();
        if(count($allPost) > 0){
            $input_token = $this->_input->post('csrf_token');
            if($input_token){
                if($this->token() == $input_token){
                    return true;
                }
                throw new \Exception("CSRF Token corrupted",500);
            }
            throw new \Exception("Missing scrf_token from POST request",400);
        }
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new CSRF();
        }

        return self::$_instance;
    }

}