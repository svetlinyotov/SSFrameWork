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
$route->addRoute('get', '/user/{id}', 'UsersController@show');
$route->addRoute('get', '/msg/{id}', 'MessagesController@send');


$route->area(['name'=>'forum', 'prefix'=>'/supercoolforum'],
    [
        ['post', '/topics/{id}', 'TopicsController@listTopics'],
        ['get', '/topics/add', 'TopicsController@create'],
        ['get', '/answers', 'AnswersController@list']
    ]
);
