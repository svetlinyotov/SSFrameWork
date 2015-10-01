<?php

namespace App\Areas\Admin\Controllers;


use app\Areas\Admin\Bindings\BanCreateBindingModel;
use App\Areas\Admin\Models\Ban;
use SSFrame\DefaultController;
use SSFrame\Facades\Redirect;
use SSFrame\Facades\View;

class BanController extends DefaultController
{

    /**
     * @param \App\Areas\Admin\Models\Ban $ban
     */
    public function index(Ban $ban)
    {
        View::appendToLayout('body', "ban");
        View::display('layouts.main', ['bans'=>$ban->listAll()]);
    }

    /**
     * @param \App\Areas\Admin\Models\Ban $ban
     * @param \App\Areas\Admin\Bindings\BanCreateBindingModel $input
     */
    public function create(Ban $ban, BanCreateBindingModel $input)
    {
        $ban->add($input->ip);
        Redirect::to('back')->go();
    }

    /**
     * @param $id
     * @param \App\Areas\Admin\Models\Ban $ban
     */
    public function destroy($id, Ban $ban)
    {
        $ban->delete($id);
        Redirect::to('back')->go();
    }

}