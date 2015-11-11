<?php

namespace App\Controllers;


use App\Bindings\AuthLoginBindingModel;
use App\Bindings\AuthRegisterBindingModel;
use App\Models\User;

class AuthController extends BaseController
{
    /**
     * @UnAuthorized('/home')
     */
    public function index()
    {
        $this->view->appendToLayout('body', "auth.login");
        $this->view->display('layouts.main');
    }

    /**
     * @UnAuthorized
     */
    public function register()
    {
        $this->view->appendToLayout('body', "auth.register");
        $this->view->display('layouts.main');
    }

    /**
     * @param AuthLoginBindingModel $user
     * @UnAuthorized
     */
    public function authorize(AuthLoginBindingModel $user)
    {
        $this->validation->validate($user,[
            'email' => 'required|email|min:5',
            'password' => 'required|min:5'
        ]);


        if($this->validation->getErrors() == false){
            if(!$this->auth->make($user->email, $user->password, $user->remember)){;
                $this->redirect->to('/login')->withErrors(['User does not exist'])->withInput(['email'=>$user->email])->go();
            }
            $this->redirect->to('/')->go();

        }else{
            $this->redirect->to('/login')->withErrors($this->validation->getErrors())->withInput(['email'=>$user->email])->go();
        }
    }

    /**
     * @param AuthRegisterBindingModel $user
     * @param User $model
     * @UnAuthorized
     */
    public function registration(AuthRegisterBindingModel $user, User $model)
    {
        $this->validation->validate($user,[
            'email' => 'required|email|min:5',
            'password' => 'required|min:5',
            'repassword' => 'required|min:5|matches:'.$user->getPassword(),
            'names' => 'required',
        ]);

        if($this->validation->getErrors() == false){
            $model->create($user->getEmail(), $user->getPassword(), $user->getNames());
            $this->redirect->to('/')->go();

        }else{
            $this->redirect->to('/register')->withErrors($this->validation->getErrors())->withInput(['email'=>$user->getEmail(), 'names'=>$user->getNames()])->go();
        }
    }

    /**
     * @Authorized
     */
    public function logout()
    {
        return $this->auth->logout();
    }

}