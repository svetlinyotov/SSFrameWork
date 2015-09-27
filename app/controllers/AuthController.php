<?php

namespace App\Controllers;


use App\Bindings\AuthLoginBindingModel;
use SSFrame\Facades\Auth;
use SSFrame\Facades\Redirect;
use SSFrame\Facades\Validation;
use SSFrame\Facades\View;

class AuthController extends \SSFrame\Auth
{
    /**
     * @UnAuthorized
     */
    public function index()
    {
        View::appendToLayout('body', "auth.login");
        View::display('layouts.main');
    }

    /**
     * @param \App\Bindings\AuthLoginBindingModel $user
     * @UnAuthorized
     */
    public function authorize(AuthLoginBindingModel $user)
    {
        Validation::validate((array)$user,[
            'email' => 'required|email|min:5',
            'password' => 'required|min:5'
        ]);


        if(Validation::getErrors() == false){
            if(!Auth::make($user->email, $user->password, $user->remember)){;
                Redirect::to('/login')->withErrors(['User does not exist'])->withInput(['email'=>$user->email])->go();
            }
            Redirect::to('/login')->go();

        }else{
            Redirect::to('/login')->withErrors(Validation::getErrors())->withInput(['email'=>$user->email])->go();
        }
    }

}