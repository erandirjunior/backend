<?php

use \PlugRoute\PlugRoute;
use \PlugRoute\RouteContainer;
use \PlugRoute\Http\RequestCreator;

$route = new PlugRoute(new RouteContainer(), RequestCreator::create());

$dependecies = require_once 'dependencies.php';

$route->options('/{anything}', function () {
    return '';
});

$route->group(['prefix' => '/', 'namespace' => 'SRC\Application\Controller'], function ($route) {
    $route->get('clients', '\\ClientFindAll@findAll');

    $route->post('clients', '\\ClientCreate@create');

    $route->put('clients/{id:\d+}', '');

    $route->delete('clients/{id:\d+}', '\\ClientDelete@delete');

    $route->get('clients/{id:\d+}', '\\ClientFind@findById');
});


$route->on($dependecies);