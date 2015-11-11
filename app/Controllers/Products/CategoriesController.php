<?php

namespace App\Controllers\Products;


use App\Bindings\AddEditCategoryBindingModel;
use App\Controllers\BaseController;
use App\Models\Categories;
use SSFrame\BindingModel;
use SSFrame\Files\FileUpload;
use SSFrame\InputData;
use SSFrame\Request;

class CategoriesController extends BaseController
{

    /**
     * @param Categories $categories
     */
    public function index(Categories $categories)
    {
        $this->view->appendToLayout('body', "products.categories");
        $this->view->display('layouts.main', ['data'=>$categories->listAll()]);
    }


    /**
     * @param AddEditCategoryBindingModel $input
     * @param Categories $category
     * @Authorized('/login')
     * @UserRole(0,1)
     */
    public function add(AddEditCategoryBindingModel $input, Categories $category)
    {
        //return var_dump($input->post('title'));
        $file_name = time().rand(100,999);
        $file = FileUpload::postImage($_FILES['photo'], $file_name, __DIR__.'/../../../public/user_data/categories', false, 300);
        $category->add($input->title, $input->description, $file);
        $this->redirect->to('/products')->go();
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
        $this->redirect->to('/products')->go();
    }

    /**
     * @param \App\Models\Categories $category
     * @Authorized
     * @UserRole(0,1)
     */
    public function delete($id, Categories $category)
    {
        $category->delete($id);
        $this->redirect->to('/products')->go();
    }
}