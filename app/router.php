<?php
use \SSFrame\Routers\Route;

$route = new Route();
$route->addRoute('get', '/login', 'AuthController@index');
$route->addRoute('get', '/logout', 'AuthController@logout');
$route->addRoute('post', '/login', 'AuthController@authorize');
$route->addRoute('get', '/register', 'AuthController@register');
$route->addRoute('post', '/register', 'AuthController@registration');
$route->addRoute('get', '/admin', 'Products\CategoriesController@index');
$route->addRoute('get', '/products', 'Products\CategoriesController@index');
$route->addRoute('get', '/products/categories', 'Products\CategoriesController@index');
$route->addRoute('get', '/products/category/{id}', 'Products\ProductsController@listAll');
$route->addRoute('get', '/products/product/{id}', 'Products\ProductsController@getProduct');
$route->addRoute('post', '/review/{product_id}', 'Products\ReviewsController@update');

//Areas
/*
$route->area(['name'=>'admin', 'prefix'=>'/admin'],
    [
        ['get', '/', 'CategoriesController@index'],
        ['get', '/category/{id}', 'CategoriesController@index'],
    ]
);*/
