<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Route;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Passport 注册发出访问令牌并撤销访问令牌、客户端和个人访问令牌所必需的路由：
        Passport::routes();

        // Token 过期时间 
        Passport::tokensExpireIn(now()->addDays(1));

        // 在这个时间内，可以通过refresh_token换取新的token
        // 会在 oauth_access_tokens 和 oauth_access_token_providers 两个表中插入新的一条数据
        Passport::refreshTokensExpireIn(now()->addDays(2));

        /**
         * Middleware `oauth.providers` middleware defined on $routeMiddleware above
         */
        Route::group(['middleware' => 'oauth.providers'], function () {
            Passport::routes(function ($router) {
                return $router->forAccessTokens();
            });
        });
    }
}
