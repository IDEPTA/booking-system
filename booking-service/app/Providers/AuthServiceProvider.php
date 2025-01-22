<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
                list($tokenId, $plainTextToken) = explode('|', $token, 2);
                $hashedToken = hash('sha256', $plainTextToken);
                $token = DB::table('personal_access_tokens')
                    ->where('token', $hashedToken)
                    ->where('id', $tokenId)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

                $user = DB::table('users')->where("id", $token->tokenable_id)->first();

                return $user;
            }
        });
    }
}
