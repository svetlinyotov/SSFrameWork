<?php

namespace App\Areas\Forum\Controllers;

use SSFrame\View;

class TopicsController
{
    public function listTopics()
    {
        $view = View::getInstance();


        $view->username = "cool";
        $view->appendToLayout('body', 'some');
        $view->display('layouts.default', ['somevar' => 23432, 'someCoolVar' => [435, 435345, 435435]]);
    }
}