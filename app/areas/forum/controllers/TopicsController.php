<?php

namespace App\Areas\Forum\Controllers;

use App\Areas\Forum\Models\Answers;
use App\Areas\Forum\Models\Topics;
use App\Bindings\UserBindingModel;
use SSFrame\Auth;
use SSFrame\BindingModel;
use SSFrame\InputData;
use SSFrame\View;

class TopicsController
{

    /**
     * @param $someId
     * @param \App\Bindings\UserBindingModel $m
     * @throws \Exception
     */
    public function listTopics($someId, UserBindingModel $m)
    {
        var_dump($m->getName());
        echo "<hr>";
        $auth = Auth::getInstance();
        echo "<pre>".print_r($auth->make('sis', 'test', true), true)."</pre>";
        echo "<pre>".print_r($auth->user()->id)."</pre>";

        //$g = new UserBindingModel();
        //echo "<pre>".print_r($g->getName(), true)."</pre>";

        $view = View::getInstance();

        $view->username = InputData::getInstance()->post('name', 'string', 'nqma_ime').$someId;

        $view->answers = Answers::class;
        $view->appendToLayout('body', 'some');
        $view->display('layouts.default', ['somevar' => 23432, 'someCoolVar' => [435, 435345, 435435], 'data'=>Topics::class]);
    }
}