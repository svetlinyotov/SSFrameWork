<?php

namespace App\Areas\Admin\Controllers;


use App\Areas\Admin\Bindings\BanUserBindingModel;
use App\Areas\Admin\Models\Users;
use SSFrame\DefaultController;
use SSFrame\Facades\Redirect;
use SSFrame\Facades\View;

class UsersController extends BaseController
{
    /**
     * @param \App\Areas\Admin\Models\Users $user/**
     * @Authorized
     * @UserRole(0)
     */
    public function index(Users $user)
    {
        View::appendToLayout('body', "users");
        View::display('layouts.main', ['users'=>$user->listAll()]);
    }

    /**
     * @param \App\Areas\Admin\Models\Users $user
     * @param \App\Areas\Admin\Bindings\BanUserBindingModel $input
     * @Authorized
     * @UserRole(0)
     */
    public function create(Users $user, BanUserBindingModel $input)
    {
        $user->add($input->email);
        Redirect::to('back')->go();
    }

    /**
     * @param $id
     * @param \App\Areas\Admin\Models\Users $user
     * @Authorized
     * @UserRole(0)
     */
    public function destroy($id, Users $user)
    {
        $user->delete($id);
        Redirect::to('back')->go();
    }

}