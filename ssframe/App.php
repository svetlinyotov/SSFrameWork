<?php

/**
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

use SSFrame\Routers\Route;

class App {

    private static $_instance = null;
    private $_frontController = null;
    private $router = null;

    private function __construct() {
        Loader::envParser();
        Loader::registerNamespace('SSFrame', dirname(__DIR__).'/SSFrame');
        Loader::registerAutoLoad();
        Config::getInstance()->setConfigFolder(Loader::env("CONFIG_DIR"));
        Loader::registerNamespaces(Config::get('app.namespaces'));
        $this -> setRouter(Config::get('app.router'));

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
        $this -> _frontController = FrontController::getInstance();

        if($this -> router instanceof \SSFrame\Routers\iRouter){
            $this -> _frontController -> setRouter($this -> router);
        }else{

            $this -> _frontController -> setRouter(new Route());
        }

        $this -> _frontController -> parseRouter();

    }

    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }


}