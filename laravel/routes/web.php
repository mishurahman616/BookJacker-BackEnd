<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function(){
    return 'Nothing to do';
});
$router->get('/getallbooks', ['middleware'=>'auth','uses'=>'BookController@selectAll']);
$router->get('/bookById/{id}', ['middleware'=>'auth', 'uses'=>'BookController@selectBookById']);
$router->get('/bookByName/{name}', ['middleware'=>'auth', 'uses'=>'BookController@selectBookByName']);
$router->post('/insert', ['middleware'=>'auth', 'uses'=>'BookController@insertBook']);
$router->get('/scrap/{name}', ['middleware'=>'auth', 'uses'=>'ScrapController@scrap']);
$router->get('/getDLink/{link}', ['middleware'=>'auth', 'uses'=>'ScrapController@downloadLink']);
$router->get('/googlesearch/{name}', ['middleware'=>'auth', 'uses'=>'ScrapController@googlesearch']);
$router->post('/userRegister', ['middleware'=>['cors'], 'uses'=>'UserController@userRegister']);
$router->post('/userLogin', ['middleware'=>['cors'], 'uses'=>'UserController@userLogin']);
$router->post('/uploadBook', ['middleware'=>['cors'], 'uses'=>'UserBookController@uploadBook']);
$router->post('/getUserBooks', ['middleware'=>['cors'], 'uses'=>'UserBookController@getUserBooks']);
$router->post('/getUserBookById', ['middleware'=>['cors'], 'uses'=>'UserBookController@getUserBookById']);
$router->post('/bookDeleteById', ['middleware'=>['cors'], 'uses'=>'UserBookController@bookDeleteById']);


