<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repository\Contracts\{
    ExpenseRepositoryInterface,
    UserRepositoryInterface
};
use App\Repository\Eloquent\{
    ExpenseRepository,
    UserRepository
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            ExpenseRepositoryInterface::class,
            ExpenseRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
