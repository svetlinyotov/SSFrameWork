<?php

namespace SSFrame;


class BindingModel extends InputData
{
    public $csrf_token;

    public function __construct()
    {
        $this->populateWithPost($this);
        return $this;
    }

    public function __call($method, $args)
    {
        $property = strtolower(preg_replace('/get/', '', $method));

        if(property_exists($this, $property)){
            return $this->{$property};
        }

        throw new \Exception("Property $property is not defined", 400);
    }

    public function getCsrfToken()
    {
        return $this->csrf_token;
    }

    function populateWithPost ($obj)
    {
        $post = parent::getInstance()->postAll();

        foreach ($post as $var => $value) {

            if(property_exists($obj, $var)) {
                if(is_array($value)){
                    $obj->{$var} = array_map('trim',$value);
                }else {
					//$setter = 'set'.$var;
					//$obj->$setter($value);
                    $obj->{$var} = trim($value);
                }
            }else{
                throw new \Exception("Unexpected value for $var form input", 400);
            }
        }

    }
}