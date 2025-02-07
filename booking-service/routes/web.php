<?php

use App\Models\BookingRecord;
use App\Models\BookingRecords;


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
        $router->get('/bookingObjects', "BookingObjectsController@index");
        $router->get('/bookingObjects/{id}', "BookingObjectsController@show");
        $router->post('/bookingObjects', "BookingObjectsController@create");
        $router->put('/bookingObjects/{id}', "BookingObjectsController@update");
        $router->delete('/bookingObjects/{id}', "BookingObjectsController@delete");

        $router->get('/bookingPosts', "BookingPostsController@index");
        $router->get('/bookingPosts/{id}', "BookingPostsController@show");
        $router->post('/bookingPosts', "BookingPostsController@create");
        $router->put('/bookingPosts/{id}', "BookingPostsController@update");
        $router->delete('/bookingPosts/{id}', "BookingPostsController@delete");
        $router->post('/bookingPosts/reservation/{id}', "BookingPostsController@reservation");

        $router->get('/bookingRecords', "BookingRecordsController@index");
        $router->get('/bookingRecords/{id}', "BookingRecordsController@show");
        $router->post('/bookingRecords', "BookingRecordsController@create");
        $router->put('/bookingRecords/{id}', "BookingRecordsController@update");
        $router->delete('/bookingRecords/{id}', "BookingRecordsController@delete");
        $router->get('/bookingRecords/cancelReservation/{id}', "BookingRecordsController@cancelReservation");
    }
);
