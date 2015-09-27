<?php

namespace SSFrame\Sessions;

class NativeSession implements ISession
{
    /**
     * @param $name
     * @param int $lifetime
     * @param null $path
     * @param null $domain
     * @param bool|false $secure
     */
    public function __construct($name, $lifetime = 3600, $path = null, $domain = null, $secure = false) {
        if(strlen($name)<1){
            $name='_sess';
        }
        session_name($name);
        session_set_cookie_params($lifetime, $path, $domain, $secure, true);//'true' means accessible only from http, not from JS
        session_start();
    }

    public function __get($name) {
        return $_SESSION[$name];
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function destroySession() {
        session_destroy();
    }

    public function unsetKey($name)
    {
        unset($_SESSION[$name]);
    }

    public function getSessionId() {
        return session_id();
    }

    public function saveSession() {
        session_write_close();
    }
}



