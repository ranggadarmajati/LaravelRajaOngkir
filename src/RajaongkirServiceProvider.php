<?php

namespace Rdj\Rajaongkir;

use Rdj\Rajaongkir\Rajaongkir;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class RajaongkirServiceProvider extends ServiceProvider
{
    /**
    * {@inheritDoc}
    */
   protected $defer = true;

   /**
    * Bootstrap the application services.
    *
    * @return void
    */
   public function boot()
   {
       $this->publishes([
            __DIR__.'/config/rajaongkir_api.php' => config_path('rajaongkir_api.php'),
        ]);
   }

   /**
    * Register the application services.
    *
    * @return void
    */
   public function register()
   {
       $this->app->singleton('Rajaongkir', function ($app) {
           return new Rajaongkir(new HttpClient);
       });
   }

   /**
    * Get the services provided by the provider.
    *
    * @return array
    */
   public function provides()
   {
       return ['Rajaongkir'];
   }
}
