<?php

namespace App\Controllers\Products;


use App\Bindings\AddEditCategoryBindingModel;
use App\Controllers\BaseController;
use App\Models\Categories;
use SSFrame\Facades\Redirect;
use SSFrame\Files\FileUpload;

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


    /**
     * @param \App\Bindings\AddEditCategoryBindingModel $input
     * @param \App\Models\Categories $category
     * @Authorized('/login')
     * @UserRole(0,1)
     */
    public function add(AddEditCategoryBindingModel $input, Categories $category)
    {
        $file_name = time().rand(100,999);
        $file = FileUpload::postImage($_FILES['photo'], $file_name, __DIR__.'/../../../public/user_data/categories', false, 300);
        $category->add($input->title, $input->description, $file);
        Redirect::to('/products')->go();
    }

    /**
     * @param \App\Bindings\AddEditCategoryBindingModel $input
     * @param \App\Models\Categories $category
     * @Authorized
     * @UserRole(0)
     */
    public function edit($id, AddEditCategoryBindingModel $input, Categories $category)
    {
        $file = null;
        if($_FILES['photo']['name'] != "") {
            $file_name = time() . rand(100, 999);
            $file = FileUpload::postImage($_FILES['photo'], $file_name, __DIR__ . '/../../../public/user_data/categories', false, 300);
        }

        $category->edit($id, $input->title, $input->description, $file);
        Redirect::to('/products')->go();
    }

    /**
     * @param \App\Models\Categories $category
     * @Authorized
     * @UserRole(0,1)
     */
    public function delete($id, Categories $category)
    {
        $category->delete($id);
        Redirect::to('/products')->go();
    }
}