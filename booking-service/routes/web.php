<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $router->get('/bookingItems', "BookingItemsController@index");
        $router->get('/bookingItems/{id}', "BookingItemsController@show");
        $router->post('/bookingItems', "BookingItemsController@create");
        $router->put('/bookingItems/{id}', "BookingItemsController@update");
        $router->delete('/bookingItems/{id}', "BookingItemsController@delete");
    }
);