<?php

namespace App\Controllers;

use SSFrame\Facades\Config;
use SSFrame\Validation;
use SSFrame\View;

class MessagesController extends BaseController
{

    public function send(){

        /*
        $val = new Validation();
        //$val->setRule('url', 'http//az.c')->setRule('minLength', 'http://az.c', 100);
        //var_dump($val->validate());


        $val->validate(
            [
                'name' => 'dstrrg',
                'age' => '10'
            ],
            [
                'name' => 'alpha|minLength:5',
                'age' => 'numeric|minLength:2|matches:10'
            ]
        );


        echo "<pre>".print_r($val->getErrors(), true)."</pre>";


*/


        $view = View::getInstance();


        $view->username = "cool";
        $view->appendToLayout('body', 'admin.index');
        $view->display('layouts.default', ['somevar' => 23432, 'someCoolVar' => [435, 435345, 435435]]);

    }
}