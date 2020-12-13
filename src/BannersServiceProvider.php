<?php

namespace Delights\Banners;

use Illuminate\Support\ServiceProvider;

class BannersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'banners');
        $this->mergeConfigFrom(__DIR__ . '/../config/banners.php', 'banners');

        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/banners.php' => config_path('banners.php'),
        ]);
    }
}
