<?php

/**
 *
 * Calls a router
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      FrontController.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame;

use ReflectionMethod;
use SSFrame\Routers\Route;
use SSFrame\Routers\RouterInterface;
use SSFrame\Routers\UrlRouter;

class FrontController {

    private static $_instance = null;
    /*
     * @var \SSFrame\Routers\RouterInterface;
     */
    private $router = null;
    private $declaredActions = [];
    public $controller = null;
    public $method = null;
    public $params = array();
    public $action = null;

    private function __construct() {
        $routerFile = config("app.router_default_path");
        if($routerFile && is_file($routerFile) && is_readable($routerFile)){
            include_once("".config("app.router_default_path")."");
        }else{
            throw new \Exception('Router file not specified', 400);
        }
    }

    /**
     * @return null
     */
    public function getRouter(){
        return $this->router;
    }

    /**
     * @param null|Routers\iRouter|Routers\RouterInterface $router
     */
    public function setRouter(RouterInterface $router){
        $this->router = $router;
    }

    public function parseRouter() {

        if($this -> router == null) {
            throw new \Exception('No valid router found', 500);
        }

        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $this->router->getURI($requestMethod);

        $this->controller = ucfirst($this->router->controller);
        $this->method = $this->router->method;
        $this->params = $this->router->params;

        if($this->controller == null){
            if(config("app.second_step_routing") === false) {
                throw new \Exception('Route for uri: ' . $requestMethod . ' was not found');
            }

            $this->setRouter(new UrlRouter());
            $this->parseRouter();

            $this -> action = $this -> controller.'Controller@'.$this->method;

            if($this->checkIfRouteDefined() == true){
                throw new \Exception('Action '.$this->action.' already defined in a custom route');
            }

            $this->loadRoute();

        }

        if($this->router instanceof Route){
            $this->loadRoute();
        }

    }

    public function checkIfRouteDefined(){
        $_route = new Route();
        $_route->getURI();

        foreach ($_route->row as $route) {
            if($this->action == array_values($route['method'])[0]){
                return true;
            }
        }

        return false;
    }

    /**
     * @throws \Exception
     */
    private function loadRoute(){
        $file = $this -> controller.'Controller';
        $input = InputData::getInstance();
        $input->setPost($this->router->getPost());

        if(!class_exists($file)) {
            throw new \Exception('Class '.$file.' not found.');
        }
        if(!method_exists($file, $this->method)){
            throw new \Exception('Method '.$this->method.' not found in class '.$file.'.');
        }

        $newController = new $file();

        $method = new ReflectionMethod($newController, $this -> method);
        $number_of_params_expected = $method->getNumberOfParameters();

        if(count($this->params) < $number_of_params_expected){
            $difference = $number_of_params_expected - count($this->params);
            for($i = 1; $i <= $difference; $i++){
                $this->params[] = null;
            }
        }
        call_user_func_array(array($newController, $this -> method), $this->params);
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new FrontController();
        }

        return self::$_instance;
    }

}