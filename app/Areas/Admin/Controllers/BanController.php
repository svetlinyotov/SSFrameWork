<?php

namespace App\Areas\Admin\Controllers;


use App\Areas\Admin\Bindings\BanCreateBindingModel;
use App\Areas\Admin\Models\Ban;

class BanController extends BaseController
{

    /**
     * @param Ban $ban
     * @Authorized
     * @UserRole(0)
     */
    public function index(Ban $ban)
    {
        $this->view->appendToLayout('body', "ban");
        $this->view->display('layouts.main', ['bans'=>$ban->listAll()]);
    }

    /**
     * @param Ban $ban
     * @param BanCreateBindingModel $input
     * @Authorized
     * @UserRole(0)
     */
    public function create(Ban $ban, BanCreateBindingModel $input)
    {
        $ban->add($input->ip);
        $this->redirect->back()->go();
    }

    /**
     * @param $id
     * @param Ban $ban
     * @Authorized
     * @UserRole(0)
     */
    public function destroy($id, Ban $ban)
    {
        $ban->delete($id);
        $this->redirect->back()->go();
    }

}