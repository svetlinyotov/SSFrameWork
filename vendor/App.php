<?php

/**
 * This file may not be redistributed in whole or significant part.
 * ------------------ THIS IS NOT FREE SOFTWARE -------------------
 *
 * Copyright 2015 All Rights Reserved
 *
 * App - main file.
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      App.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame;

include_once "Loader.php";

class App {

    private static $_instance = null;
    private $_frontController = null;
    private $router = null;

    private function __construct() {
        \SSFrame\Loader::envParser();
        \SSFrame\Loader::registerNamespace('SSFrame', dirname(__DIR__).'/SSFrame');
        \SSFrame\Loader::registerAutoLoad();
        \SSFrame\Config::getInstance()->setConfigFolder(\SSFrame\Loader::env("CONFIG_DIR"));
        \SSFrame\Loader::registerNamespaces(\SSFrame\Config::get('app.namespaces'));
        $this -> setRouter(\SSFrame\Config::get('app.router'));

    }

    /**
     * @param null $router
     */
    public function setRouter($router){
        $this->router = $router;
    }

    /**
     * @return \SSFrame\Config
     */
    public function getConfig() {
        return $this->_config;
    }

    public function run() {
        $this -> _frontController = \SSFrame\FrontController::getInstance();

        if($this -> router instanceof \SSFrame\Routers\iRouter){
            $this -> _frontController -> setRouter($this -> router);
        }else if($this -> router == 'urlParser'){
            $this -> _frontController -> setRouter(new \SSFrame\Routers\UrlRouter());
        }else{
            $this -> _frontController -> setRouter(new \SSFrame\Routers\Route());
        }

        $this -> _frontController -> parseRouter();
    }

    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new \SSFrame\App();
        }

        return self::$_instance;
    }


}