<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->bearerToken();
            if ($token) {
                $now = Carbon::now()->toDateTimeString();
                list($tokenId, $plainTextToken) = explode('|', $token, 2);
                $hashedToken = hash('sha256', $plainTextToken);
                $tokenFromDB = DB::table('personal_access_tokens')
                    ->where('id', $tokenId)
                    ->where('token',  "$hashedToken")
                    ->where('expires_at', '>', "$now")
                    ->first();

                if (!$tokenFromDB) {
                    throw new AuthenticationException("Token not founded");
                }
                log::info([
                    "token" => $token,
                    "tokenId" => $tokenId,
                    "hashedToken" => $hashedToken,
                    "tokenFromDB" => $tokenFromDB,
                    "date now" => Carbon::now()->toDateTimeString(),
                ]);
                $user = DB::table('users')->where("id", $tokenFromDB->tokenable_id)->first();

                return $user;
            }
        });
    }
}
