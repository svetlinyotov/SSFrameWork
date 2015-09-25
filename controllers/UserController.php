<?php

namespace Controllers;

class UserController {
    public function image($target, $id, $id4){
        echo '<pre>' . print_r($target, true) . '</pre>';
        echo '<pre>' . print_r($id, true) . '</pre>';
        echo '<pre>' . print_r($id4, true) . '</pre>';
    }
}