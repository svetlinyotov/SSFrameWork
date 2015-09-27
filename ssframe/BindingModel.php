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

    public function getCsrfToken()
    {
        return $this->csrf_token;
    }

    function populateWithPost ($obj)
    {
        $post = parent::getInstance()->postAll();

        foreach ($post as $var => $value) {

            if(property_exists($obj, $var)) {
                $obj->{$var} = trim($value);
            }else{
                throw new \Exception("Unexpected value for $var form input", 400);
            }
        }

    }
}