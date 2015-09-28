<?php
use \SSFrame\Routers\Route;

//Route::match('get', '/', 'HomeController@index');
//Route::match('get', '/user/', 'UserController@index');
//Route::match('get', '/user/{id}', 'UserController@show');
//Route::match('post', '/user/{id}', 'UserController@save');
//Route::match('get', '/message/send/{user}', 'MessagesController@send');
//Route::match('get', '/getalluser/images/{target}/{id}/{id2?}', 'UserController@image');
//Route::match('get', '/supercoolforum/topics', 'UserController@image');
//
//

$route = new Route();
$route->addRoute('get', '/login', 'AuthController@index');
$route->addRoute('get', '/logout', 'AuthController@logout');
$route->addRoute('post', '/login', 'AuthController@authorize');
$route->addRoute('get', '/register', 'AuthController@register');
$route->addRoute('post', '/register', 'AuthController@registration');


$route->area(['name'=>'forum', 'prefix'=>'/supercoolforum'],
    [
        ['post', '/topics/{id}', 'TopicsController@listTopics'],
        ['get', '/topics/add', 'TopicsController@create'],
        ['get', '/answers', 'AnswersController@list']
    ]
);
