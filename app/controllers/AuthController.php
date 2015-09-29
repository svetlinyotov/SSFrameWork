<?php

namespace App\Controllers;


use App\Bindings\AuthLoginBindingModel;
use App\Bindings\AuthRegisterBindingModel;
use App\Models\User;
use SSFrame\Facades\Auth;
use SSFrame\Facades\Redirect;
use SSFrame\Facades\Validation;
use SSFrame\Facades\View;

class AuthController extends \SSFrame\Auth
{
    /**
     * @UnAuthorized('/home')
     */
    public function index()
    {
        View::appendToLayout('body', "auth.login");
        View::display('layouts.main');
    }

    /**
     * @UnAuthorized
     */
    public function register()
    {
        View::appendToLayout('body', "auth.register");
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

    /**
     * @param \App\Bindings\AuthRegisterBindingModel $user
     * @param \App\Models\User $model
     * @UnAuthorized
     */
    public function registration(AuthRegisterBindingModel $user, User $model)
    {
        Validation::validate((array)$user,[
            'email' => 'required|email|min:5',
            'password' => 'required|min:5',
            'repassword' => 'required|min:5|matches:'.$user->getPassword(),
            'names' => 'required',
        ]);

        if(Validation::getErrors() == false){
            $model->create($user->getEmail(), $user->getPassword(), $user->getNames());
            Redirect::to('/')->go();

        }else{
            Redirect::to('/register')->withErrors(Validation::getErrors())->withInput(['email'=>$user->getEmail(), 'names'=>$user->getNames()])->go();
        }
    }

    /**
     * Only for testing
     * @Authorized
     * @UserRole(1 , 2 , 0, 3 )
     */
    public function profile()
    {
        return "asdasd";
    }

}