<?php

namespace App\Providers;

use App\Services\Contracts\ItemServiceInterface;
use App\Services\ItemService;
use Illuminate\Support\ServiceProvider;

class ExampleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ItemServiceInterface::class, function ($app) {
            return new ItemService();
        });
    }
}
