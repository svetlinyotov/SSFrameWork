<?php

namespace SSFrame;


class Request
{
    /**
     * @var InputData
     */
    var $input_data;

    public function __constructor() {
        $this->input_data = InputData::getInstance();
    }

    public function __call($name, $v)
    {
        return InputData::getInstance()->$name($v[0], $v[1], $v[2]);
    }
}