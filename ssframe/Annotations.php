<?php

namespace SSFrame;

use SSFrame\Facades\Redirect;


class Annotations
{
    public static $_instance=null;

    public function __construct($docCom)
    {
        if(strpos($docCom, "@UnAuthorized")){
            $this->unauthorized();
        }
        if(strpos($docCom, "@Authorized")){
            $this->authorized();
        }
    }

    public function unauthorized(){
        if(\SSFrame\Facades\Auth::user() == true){
            Redirect::to('/')->go();
        }
    }

    public function authorized(){
        if(\SSFrame\Facades\Auth::user() == false){
            Redirect::to('/')->go();
        }
    }

    public static function getInstance($docCom)
    {
        if (!self::$_instance) {
            self::$_instance = new Annotations($docCom);
        }

        return self::$_instance;
    }

}