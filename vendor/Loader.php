<?php

/**
 *
 * Auto loader file
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      Loader.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame;

final class Loader {

    private static $namespaces = array();

    private function __construct() {

    }

    public static function registerAutoLoad() {
        spl_autoload_register(array('\SSFrame\Loader', 'autoload'));
    }

    public static function autoload($className){
        foreach (self::$namespaces as $namespace => $path) {
            if(substr($className, 0, strlen($namespace)) == $namespace){
                $_path = substr($className, strlen($namespace), strlen($className));
                $_path = str_replace('\\', DIRECTORY_SEPARATOR, $_path);
                $_path = $path.$_path.".php";

                include "$_path";
            }
        }
    }

    public static function registerNamespace($namespace, $path) {
        $_path = realpath($path);

        if(strlen($namespace) > 0){
            if($_path && is_readable($_path) && is_dir($_path)){
                self::$namespaces[$namespace.'\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                throw new \Exception('Invalid namespace path or the path is not readable', 403);
            }
        } else {
            throw new \Exception('Namespace missing', 400);
        }
    }

    public static function registerNamespaces($arr){
        if(is_array($arr)) {
            foreach ($arr as $namespace => $path) {
                self::registerNamespace($namespace, $path);
            }
        } else {
            throw new \Exception('Invalid namespaces', 422);
        }
    }

    /**
     * @return array
     */
    public static function getNamespaces() {
        return self::$namespaces;
    }

    /**
     * @param array $namespaces
     * @internal param string $namespaces
     */
    public static function setNamespaces($namespaces) {
        self::$namespaces = $namespaces;
    }

    /**
     * @param $namespace
     * @internal param string $namespaces key
     */
    public static function removeNamespace($namespace) {
        unset(self::$namespaces[$namespace]);
    }

    public static function envParser(){
        $handle = fopen("../.env", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                list($key, $value) = explode('=', $line);
                putenv(trim($key).'='.trim($value));
            }
            fclose($handle);
        } else {
            throw new \Exception('.env file not found', 404);
        }
    }

    public static function env($key){
        $value = getenv($key);
        if($value !== false) {
            return $value;
        }
    }

}