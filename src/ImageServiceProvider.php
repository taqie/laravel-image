<?php

namespace Taqie\Image;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->publishes([
            __DIR__.'/Configs/laravel_image.php' => config_path('laravel_image.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'Configs/laravel_image.php', 'laravel_image'
        );
    }
}