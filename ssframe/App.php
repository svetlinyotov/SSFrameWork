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
use SSFrame\Sessions\Session;

class App {

    private static $_instance = null;
    private $_frontController = null;
    private $router = null;
    private $_dbConnections = array();
    private $_session = null;

    private function __construct() {
        Loader::envParser();
        Loader::registerNamespace('SSFrame', dirname(__DIR__).'/SSFrame');
        Loader::registerAutoLoad();
        Config::getInstance()->setConfigFolder(Loader::env("CONFIG_DIR"));
        Loader::registerNamespaces(Config::getInstance()->get('app.namespaces'));
        $this -> setRouter(Config::getInstance()->get('app.router'));

    }

    /**
     * @param null $router
     */
    public function setRouter($router){
        $this->router = $router;
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

    public function getDBConnection($connection = 'default') {
        if (!$connection) {
            throw new \Exception('No connection identifier provided', 500);
        }
        if ($this->_dbConnections[$connection]) {
            return $this->_dbConnections[$connection];
        }
        $_cnf = Config::getInstance()->get("database.$connection");

        if (!$_cnf) {
            throw new \Exception('No valid connection ID is provided', 500);
        }
        $dbh = new \PDO($_cnf['connection_uri'], $_cnf['username'],
            $_cnf['password'], $_cnf['pdo_options']);

        $this->_dbConnections[$connection] = $dbh;
        return $dbh;
    }

    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    public function __destruct() {
        if (Session::getInstance()->getSession() != null) {
            Session::getInstance()->getSession()->saveSession();
        }
    }

}