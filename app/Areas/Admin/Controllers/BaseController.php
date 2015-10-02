<?php

namespace App\Areas\Admin\Controllers;


use SSFrame\DefaultController;

class BaseController extends DefaultController
{
    /**
     * @Authorized
     * @UserRole(0)
     */
    public function __construct()
    {
        parent::__construct();
    }
}