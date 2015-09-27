<?php

namespace SSFrame;

use SSFrame\DB\SimpleDB;
use SSFrame\Sessions\Session;

class Auth extends SimpleDB
{

    private static $_instance;
    /**
     * @var SimpleDB
     */
    private $_user = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function make($username, $password, $remember = false)
    {

        $user = $this->sql("SELECT * FROM users WHERE username = ? AND password = ?", [$username, $password]);

        if($user->getAffectedRows() == 1){
            $token = Common::generateToken();
            Session::getInstance()->getSession()->user_token=$token;
            $this->_user = $user->fetchRowAssoc();

            $this->sql("UPDATE users SET access_token= ? WHERE id = ?", [$token, $this->_user['id']]);

            return true;
        }

        return false;

    }

    public function logout()
    {
        $this->sql("UPDATE users SET access_token= '' WHERE id = ?", [ $this->user()->id]);
        Session::getInstance()->getSession()->unsetKey('user_token');

    }

    public function user()
    {
        return (object)$this->_user;
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new Auth();
        }

        return self::$_instance;
    }

}