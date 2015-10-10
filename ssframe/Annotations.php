<?php

namespace SSFrame;

use SSFrame\Facades\Redirect;


class Annotations
{
    public static $_instance=null;

    public function __construct($docCom)
    {
        preg_match_all("/@([a-zA-Z]+)(\\(('|\")?([^'\"]+)('|\")?\\))?/", $docCom, $matches);

        foreach ($matches[1] as $key=>$match) {
            $parameter = $matches[4][$key];

            if($match == "UnAuthorized"){
                $this->unauthorized($parameter);
            }
            if($match == "Authorized"){
                $this->authorized($parameter);
            }
            if($match == "UserRole"){
                $this->userRole($parameter);
            }
        }

        return false;

    }

    public function unauthorized($url){
        if(\SSFrame\Facades\Auth::user() == true){
            if(strlen($url) > 0) {
                Redirect::to($url)->go();
            }
            throw new \Exception("Accessing method forbidden", 402);
        }
    }

    public function authorized($url){
        if(\SSFrame\Facades\Auth::user() == false){
            if(strlen($url) > 0) {
                Redirect::to($url)->go();
            }
            throw new \Exception("Accessing method forbidden", 402);
        }
    }

    public function userRole($id)
    {
        if(\SSFrame\Facades\Auth::user() == true) {
            $roles = array_map('trim', explode(",", $id));
            $current_role = \SSFrame\Facades\Auth::user()->role;

            if (array_search($current_role, $roles) === false) {
                throw new \Exception("Current user's role not authorized", 401);
            }
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