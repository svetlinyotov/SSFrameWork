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
     * @param Users $user
     * @Authorized
     * @UserRole(0)
     */
    public function index(Users $user)
    {
        $this->view->appendToLayout('body', "users");
        $this->view->display('layouts.main', ['users'=>$user->listAll()]);
    }

    /**
     * @param Users $user
     * @param BanUserBindingModel $input
     * @Authorized
     * @UserRole(0)
     */
    public function create(Users $user, BanUserBindingModel $input)
    {
        $user->add($input->email);
        $this->redirect->back()->go();
    }

    /**
     * @param $id
     * @param Users $user
     * @Authorized
     * @UserRole(0)
     */
    public function destroy($id, Users $user)
    {
        $user->delete($id);
        $this->redirect->back()->go();
    }

}