<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Uncomment if you don't wish to cache all users
        $this->app->bind(
            'App\Repositories\User\UserRepository',
            'App\Repositories\User\EloquentUserRepository'
        );

        $this->app->bind(
            'App\Repositories\FriendRequest\FriendRequestRepository',
            'App\Repositories\FriendRequest\EloquentFriendRequestRepository'
        );

        $this->app->bind(
            'App\Repositories\Group\GroupRepository',
            'App\Repositories\Group\EloquentGroupRepository'
        );

        $this->app->bind(
            'App\Repositories\GroupRequest\GroupRequestRepository',
            'App\Repositories\GroupRequest\EloquentGroupRequestRepository'
        );
    }
}
