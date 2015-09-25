<?php

namespace Controllers;

class MessagesController {
    public function send($target, $id, $id4){
        echo '<pre>' . var_dump($target) . '</pre>';
        echo '<pre>' . var_dump($id) . '</pre>';
        echo '<pre>' . var_dump($id4) . '</pre>';
    }
}