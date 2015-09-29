<?php

namespace App\Controllers\Products;


use App\Controllers\BaseController;
use App\Models\Categories;

class CategoriesController extends BaseController
{

    /**
     * @param \App\Models\Categories $categories
     */
    public function index(Categories $categories)
    {
        $this->view->appendToLayout('body', "products.categories");
        $this->view->display('layouts.main', ['data'=>$categories->listAll()]);
    }
}