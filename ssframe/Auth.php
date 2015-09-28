<?php

namespace SSFrame;

use SSFrame\DB\SimpleDB;
use SSFrame\Facades\Redirect;
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

    public function make($email, $password, $remember = false)
    {

        $user = $this->sql("SELECT * FROM users WHERE email = ?", [$email]);

        if($user->getAffectedRows() == 1){
            $user = $user->fetchRowAssoc();
            if(Hash::verify($password, $user['password'])) {

                $token = Common::generateToken();
                Session::getInstance()->getSession()->user_token = $token;

                $this->sql("UPDATE users SET access_token= ? WHERE id = ?", [$token, $user['id']]);

                return true;
            }
            return false;
        }

        return false;

    }

    public function byId($id)
    {
        $token = Common::generateToken();
        Session::getInstance()->getSession()->user_token = $token;

        $this->sql("UPDATE users SET access_token= ? WHERE id = ?", [$token, $id]);

        return true;
    }

    public function doAuth(){
        $current_token = Session::getInstance()->getSession()->user_token;
        if(is_string($current_token)){
            $user = $this->sql("SELECT * FROM users WHERE access_token = ?", [$current_token]);

            if($user->getAffectedRows() == 1) {
                $this->_user = $user->fetchRowAssoc();
                return $this->_user;

            }
        }
        return null;
    }

    public function logout()
    {
        $this->sql("UPDATE users SET access_token= '' WHERE id = ?", [ $this->user()->id]);
        Session::getInstance()->getSession()->unsetKey('user_token');
        Redirect::to('/home')->go();
    }

    public function user()
    {
        if(count($this->_user) > 0) {
            return (object)$this->_user;
        }
        return false;
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new Auth();
        }

        return self::$_instance;
    }

}