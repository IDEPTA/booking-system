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

// $router->get('/test2', function () use ($router) {
//     $token = request()->bearerToken();

//     if ($token) {
//         list($tokenId, $plainTextToken) = explode('|', $token, 2);
//         $hashedToken =  hash('sha256', $plainTextToken);
//         $tokenRecord = DB::table('personal_access_tokens')
//             ->where('token', $hashedToken)
//             ->first();
//         $user = DB::table('users')->where("id", $tokenRecord->tokenable_id)->first();

//         return response()->json([
//             "msg" => "Токен передался",
//             "hashedToken" => $hashedToken,
//             "tokenRecord" => $tokenRecord,
//             "token_id" => $tokenId,
//             "user" => $user,
//             "token" => $plainTextToken
//         ]);
//     }

//     return response()->json(['message' => 'Token not provided'], 400);
// });

$router->group(
    ["middleware" => "auth",],
    function () use ($router) {
        $router->get('/test', function () use ($router) {
            return $router->getRoutes();
        });
    }
);