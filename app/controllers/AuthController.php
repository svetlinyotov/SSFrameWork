<?php

namespace App\Controllers;


use App\Bindings\AuthLoginBindingModel;
use SSFrame\Facades\Auth;
use SSFrame\Facades\Redirect;
use SSFrame\Facades\Validation;
use SSFrame\Facades\View;

class AuthController
{
    public function index()
    {
        View::appendToLayout('body', "auth.login");
        View::display('layouts.main');
    }

    /**
     * @param \App\Bindings\AuthLoginBindingModel $user
     */
    public function authorize(AuthLoginBindingModel $user)
    {
        Validation::validate((array)$user,[
            'email' => 'required|email|min:5',
            'password' => 'required|min:5'
        ]);

        if(Validation::getErrors() === false){
            Auth::make($user->getEmail(), $user->getEmail(), $user->remember);
        }else{
            \SSFrame\Redirect::getInstance()->to('/login')->withErrors(Validation::getErrors())->withInput(['email'=>$user->email])->go();
        }
    }

}