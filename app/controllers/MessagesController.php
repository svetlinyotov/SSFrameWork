<?php

namespace Controllers;

use SSFrame\View;

class MessagesController
{

    public function send(){
        $view = View::getInstance();

        $view->username = "cool";
        $view->appendToLayout('body', 'admin.index');
        $view->display('layouts.default', ['somevar' => 23432, 'someCoolVar' => [435, 435345, 435435]]);
    }
}