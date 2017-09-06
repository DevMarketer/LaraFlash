<?php

namespace DevMarketer\LaraFlash;

use Illuminate\Support\ServiceProvider;

class LaraFlashServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton('laraflash', function($app)
      {
        return $this->app->make('DevMarketer\LaraFlash\LaraFlash');
        //return new LaraFlash($app);
      });
    }
}
