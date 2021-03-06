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

use SSFrame\DB\SimpleDB;
use SSFrame\Facades\Auth;
use SSFrame\Routers\Route;
use SSFrame\Sessions\Session;

class App {

    private static $_instance = null;
    private $_frontController = null;
    private $router = null;
    private $_dbConnections = array();
    private $_session = null;

    private function __construct() {
        set_exception_handler([$this, '_exceptionHandler']);
        Loader::envParser();
        Loader::registerNamespace('SSFrame', dirname(__DIR__).'/ssframe/');
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
        $db = new SimpleDB();
        $list = $db->sql("SELECT * FROM ban_ip")->fetchAllAssoc();
        foreach ($list as $ip) {
            if($_SERVER['REMOTE_ADDR'] == $ip['ip']){
                throw new \Exception("Currently your IP is blocked by admin");
            }
        }

        CSRF::getInstance()->generate();
        Auth::doAuth();
        $this -> _frontController = FrontController::getInstance();

        if($this -> router instanceof \SSFrame\Routers\iRouter){
            $this -> _frontController -> setRouter($this -> router);
        }else{

            $this -> _frontController -> setRouter(new Route());
        }



        $this -> _frontController -> parseRouter();

        CSRF::getInstance()->check();
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

    public function _exceptionHandler(\Exception $ex) {
        if (config('app.displayExceptions') == true) {
            echo '<pre>' . print_r($ex,true) . '</pre>';
        } else {
            $this->displayError($ex->getCode());
        }
    }

    public function displayError($error) {
        if($error == 0) $error = 500;
        try {
            $view = View::getInstance();
            $view->display('errors.' . $error);
        } catch (\Exception $exc) {
            Common::headerStatus($error);
            echo '<h1>View errors.' . $error . ' not found</h1>';
            exit;
        }

    }

    public function __destruct() {
        if (Session::getInstance()->getSession() != null && !headers_sent()) {
            Session::getInstance()->getSession()->saveSession();
        }
    }

}