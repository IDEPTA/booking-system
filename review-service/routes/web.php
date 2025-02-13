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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(
    ["middleware" => "auth",],
    function () use ($router) {
        $router->get('/routes', function () use ($router) {
            return $router->getRoutes();
        });

        $router->get('/reviews', "ReviewController@index");
        $router->get('/reviews/{id}', "ReviewController@show");
        $router->post('/reviews', "ReviewController@create");
        $router->put('/reviews/{id}', "ReviewController@update");
        $router->delete('/reviews/{id}', "ReviewController@delete");
    }
);
