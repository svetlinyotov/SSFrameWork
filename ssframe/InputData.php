<?php

namespace SSFrame;

class InputData
{
    private static $_instance = null;
    private $_get = array();
    private $_post = array();
    private $_cookies = array();

    public function __construct()
    {
        $this->_cookies = $_COOKIE;
    }

    public function setPost($ar)
    {
        if (is_array($ar)) {
            $this->_post = $ar;
        }
        array_walk_recursive($this->_post, [Common::class, 'filter']);
    }

    public function setGet($ar)
    {
        if (is_array($ar)) {
            $this->_get = $ar;
        }
        array_walk_recursive($this->_get, [Common::class, 'filter']);
    }

    public function hasGet($id)
    {
        return array_key_exists($id, $this->_get);
    }

    public function hasPost($name)
    {
        return array_key_exists($name, $this->_post);
    }


    public function hasCookies($name) {
        return array_key_exists($name, $this->_cookies);
    }

    public function get($id, $normalize = null, $default = null) {
        if ($this->hasGet($id)) {
            if ($normalize != null) {
                return Common::normalize($this->_get[$id], $normalize);
            }
            return $this->_get[$id];
        }
        return $default;
    }

    public function post($name, $normalize = null, $default = null) {
        if ($this->hasPost($name) && $_POST[$name] != "") {
            if ($normalize != null) {
                return Common::normalize($this->_post[$name], $normalize);
            }
            return $this->_post[$name];
        }
        return $default;
    }

    public function postAll()
    {
        return $this->_post;
    }

    public function cookies($name, $normalize = null, $default = null) {
        if ($this->hasCookies($name)) {
            if ($normalize != null) {
                return Common::normalize($this->_cookies[$name], $normalize);
            }
            return $this->_cookies[$name];
        }
        return $default;
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new InputData();
        }
        return self::$_instance;
    }

}