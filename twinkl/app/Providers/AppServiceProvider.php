<?php

namespace App\Providers;

use App\Repositories\SubscriptionUserRepository;
use App\Repositories\SubscriptionUserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SubscriptionUserRepositoryInterface::class, SubscriptionUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
