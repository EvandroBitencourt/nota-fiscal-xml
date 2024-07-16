<?php
use core\Router;

$router = new Router();

//Notas
$router->get('/', 'HomeController@index');
$router->get('/new', 'HomeController@addNota');
$router->post('/new', 'HomeController@addAction');

// $router->get('/usuario', 'UserController@index');
// $router->get('/new', 'UserController@add');
// $router->post('/new', 'UserController@addAction');

// $router->get('/usuario/{id}/editar', 'UserController@edit');
// $router->post('/usuario/{id}/editar', 'UserController@editAction');


// $router->get('/usuario/{id}/excluir', 'UserController@del');



