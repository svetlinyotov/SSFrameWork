<?php

namespace SSFrame;


use SSFrame\Sessions\Session;

class View
{
    private static $_instance = null;
    private $viewPath = null;
    private $viewDir = null;
    private $data = array();
    private $extension = '.php';
    private $layoutParts = array();
    private $layoutData = array();
    private $errors;
    private $success;
    private $input;

    private function __construct() {

        $this->viewPath = realpath(config("app.views_default_path"));

        $current_controller = FrontController::getInstance()->getRouter()->controller.'Controller';
        if(class_exists($current_controller)) {
            $reflection = new \ReflectionClass($current_controller);
            $view_path = __DIR__."/../".str_replace("\\", DIRECTORY_SEPARATOR, lcfirst($reflection->getNamespaceName())) . "/../views";

            if(is_dir($view_path) && is_readable($view_path)) {

                $this->viewPath = (config("app.namespaces")["App"] . '/../' . $view_path);
            }else{
                $this->viewPath = config("app.views_default_path");
            }
        }
        $this->errors = Session::getInstance()->getSession()->withErrors;
        $this->success = Session::getInstance()->getSession()->withSuccess;
        $this->input = Session::getInstance()->getSession()->withInput;

        Session::getInstance()->getSession()->unsetKey('withErrors');
        Session::getInstance()->getSession()->unsetKey('withSuccess');
        Session::getInstance()->getSession()->unsetKey('withInput');
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
            throw new \Exception('view path:',500);
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
var_dump($this->viewDir);
        $fl = $this->viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->extension;
        if (file_exists($fl) && is_readable($fl)) {
            //ob_start();
            //extract($this->data, EXTR_OVERWRITE);
            //include $fl;
            //return ob_get_clean();

            return self::includeFileScope($fl, $this->data);
        } else {
            throw new \Exception('View ' . $fl . ' cannot be included', 500);
        }
    }
    private static function getFileDocBlock($file)
    {
        $docComments = array_filter(
            token_get_all( file_get_contents( $file ) ), function($entry) {
            return $entry[0] == T_DOC_COMMENT;
        }
        );
        $fileDocComment = array_shift( $docComments );
        return $fileDocComment[1];
    }

    private function includeFileScope($____filePath, $__data) {
        $doc = self::getFileDocBlock($____filePath);

        if($doc != null) {
            preg_match_all('/\\@var\\s+((\\\\[A-Za-z0-9]+)+)\\s+\\$([A-Za-z0-9_]+)/', $doc, $matches);
            //echo "<pre>" . print_r($matches, true) . "</pre><br>";

            foreach ($matches[3] as $k => $var) {
                $namespace = ltrim($matches[1][$k], '\\');
                $$var = new $namespace();
                $returned = get_class($$var);
                if ($returned != $namespace) {
                    throw new \Exception("Given object type must be {$namespace}, instead given {$returned}", 400);
                }
            }
        }


        ob_start();
        $__data = (array)$__data;
        extract($__data, EXTR_OVERWRITE);
        unset($__data);
        $errors = $this->errors;
        $success = $this->success;
        $input = $this->input;
        include $____filePath;

        $clean = ob_get_clean();

        return $clean;
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