<?php
use \SSFrame\Routers\Route;

//Route::match('get', '/', 'HomeController@index');
//Route::match('get', '/user/', 'UserController@index');
//Route::match('get', '/user/{id}', 'UserController@show');
//Route::match('post', '/user/{id}', 'UserController@save');
Route::match('get', '/message/send/{user}', 'MessagesController@send');
Route::match('get', '/getalluser/images/{target}/{id}/{id2?}', 'UserController@image');