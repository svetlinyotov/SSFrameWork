<?php

namespace App\Areas\Forum\Controllers;

use App\Areas\Forum\Models\Answers;
use App\Areas\Forum\Models\Topics;
use App\Bindings\UserBindingModel;
use SSFrame\BindingModel;
use SSFrame\InputData;
use SSFrame\View;

class TopicsController
{

    public function listTopics($someId )
    {
        /*
        var_dump($m);
        $g = new BindingModel();
        echo "<pre>".print_r($g, true)."</pre>";
        echo "<br>".$g->age;
        */
        $view = View::getInstance();

        $view->username = InputData::getInstance()->post('name', 'string', 'nqma_ime').$someId;

        $view->answers = Answers::class;
        $view->appendToLayout('body', 'some');
        $view->display('layouts.default', ['somevar' => 23432, 'someCoolVar' => [435, 435345, 435435], 'data'=>Topics::class]);
    }
}