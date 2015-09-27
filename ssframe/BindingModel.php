<?php

namespace SSFrame;


class BindingModel extends InputData
{
    public function __construct()
    {
        $this->populateWithPost($this);
        return $this;
    }
    function populateWithPost ($obj)
    {
        $post = parent::getInstance()->postAll();

        foreach ($post as $var => $value) {
            $obj->{$var} = trim($value);
        }

    }
}