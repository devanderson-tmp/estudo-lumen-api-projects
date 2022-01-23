<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api', 'middleware' => 'customAuth'], function () use ($router) {
    $router->post('projects', 'ProjectController@store');
    $router->delete('projects/{id}', 'ProjectController@destroy');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', 'TokenController@generate');
    $router->get('projects', 'ProjectController@index');
    $router->get('projects/{id}', 'ProjectController@show');
    $router->get('projects/{id}/languages', 'LanguageController@index');
});

$router->get('/', function () {
    return [
        'projects' => 'https://devanderson-projetos.herokuapp.com/api/projects'
    ];
});
