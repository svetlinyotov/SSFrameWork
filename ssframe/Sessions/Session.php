<?php

namespace SSFrame\Sessions;


use SSFrame\Config;

class Session
{
    public static $_instance;
    private $_session = null;

    public function __construct() {
        $_session = Config::getInstance()->get('session');
        if ($_session['autostart']) {
            if ($_session['type'] == 'native') {
                $_s = new NativeSession($_session['name'], $_session['lifetime'], $_session['path'], $_session['domain'], $_session['secure']);
            } else if ($_session['type'] == 'database') {
                $_s = new DBSession($_session['dbConnection'],
                    $_session['name'], $_session['dbTable'], $_session['lifetime'], $_session['path'], $_session['domain'], $_session['secure']);
            } else {
                throw new \Exception('No valid session', 500);
            }
            $this->setSession($_s);
        }
    }

    public function setSession(ISession $session) {
        $this->_session = $session;
    }

    public function getSession() {
        return $this->_session;
    }

    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new Session();
        }

        return self::$_instance;
    }

}