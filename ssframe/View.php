<?php

namespace SSFrame;


class View
{
    private static $_instance = null;
    private $viewPath = null;
    private $viewDir = null;
    private $data = array();
    private $extension = '.php';
    private $layoutParts = array();
    private $layoutData = array();

    private function __construct() {


        $current_controller = FrontController::getInstance()->getRouter()->controller.'Controller';
        $reflection = new \ReflectionClass($current_controller);
        $view_path = strtolower($reflection->getNamespaceName())."/../views";

        $this->viewPath = realpath(config("app.namespaces")["App"].'/../'.$view_path);
        if ($this->viewPath == null) {
            $this->viewPath = realpath('../app/views/');
        }

    }

    public function setViewDirectory($path) {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                $this->viewDir = $path;
            } else {
                throw new \Exception('view path',500);
            }
        } else {
            throw new \Exception('view path',500);
        }
    }

    public function display($name, $data = array(), $returnAsString = false) {

        if (is_array($data)) {
            $this->data = array_merge($this->data, $data);
        }

        if (count($this->layoutParts) > 0) {
            foreach ($this->layoutParts as $k => $v) {
                $r = $this->_includeFile($v);
                if ($r) {
                    $this->layoutData[$k] = $r;
                }
            }
        }

        if ($returnAsString) {
            return $this->_includeFile($name);
        } else {
            echo $this->_includeFile($name);
        }
    }

    public function getLayoutData($name){
        return $this->layoutData[$name];
    }

    public function appendToLayout($key, $template) {
        if ($key && $template) {
            $this->layoutParts[$key] = $template;
        } else {
            throw new \Exception('Layout require valid key and template', 500);
        }
    }
    private function _includeFile($file) {
        if ($this->viewDir == null) {
            $this->setViewDirectory($this->viewPath);
        }
        $fl = $this->viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->extension;
        if (file_exists($fl) && is_readable($fl)) {
            //ob_start();
            //extract($this->data, EXTR_OVERWRITE);
            //include $fl;
            //return ob_get_clean();
            return self::includeFileScope($fl, $this->data);
        } else {
            throw new \Exception('View ' . $file . ' cannot be included', 500);
        }
    }

    static function includeFileScope($____filePath, $data) {
        ob_start();
        $data = (array)$data;
        extract($data, EXTR_OVERWRITE);
        unset($data);
        include $____filePath;
        return ob_get_clean();
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name) {
        return $this->data[$name];
    }

    /**
     * @return \SSFrame\View
     */
    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new View();
        }

        return self::$_instance;
    }

}