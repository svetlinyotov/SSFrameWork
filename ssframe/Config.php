<?php

/**
 *
 * Manage framework configuration files
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      Config.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame;

class Config {

    private static $_instance = null;
    public $configPath = null;
    public $configArray = array();

    private function __construct() {

    }

    public function setConfigFolder($path) {
        $_path = realpath($path);

        if(!$path) {
            throw new \Exception('Config folder missing', 400);
        }
        if($_path && is_readable($_path) && is_dir($_path)) {
            $this->configPath = $_path;
        }
    }

    public function includeConfigFile($path) {
        if(!$path) {
            throw new \Exception('Invalid config file path', 400);
        }

        $_path = realpath($path);
        if($_path && is_file($_path) && is_readable($_path)){
            $config = include "$_path";
            $this->configArray[basename($_path)] = $config;
        }
    }

    public function get($data) {
        if($this->configPath == null) {
            throw new \Exception('Config folder path not specified', 400);
        }
        if(!$data) {
            throw new \Exception('Bad config input', 400);
        }

        $data = trim($data);

        $params = explode(".", $data);
        if(count($params) >= 2) {
            $key = array_pop($params);
            $confInternalUrl = implode(DIRECTORY_SEPARATOR, $params);
            $file = $this->configPath . DIRECTORY_SEPARATOR . $confInternalUrl . ".php";

            if(!isset($this->configArray[basename($file)])){
                $this->includeConfigFile($file);
            }

            if(!isset($this->configArray[basename($file)][$key])){
                $this->configArray[basename($file)][$key] = 0;
            }

            return $this->configArray[basename($file)][$key];
        }
        return null;
    }

    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new Config();
        }

        return self::$_instance;
    }


}