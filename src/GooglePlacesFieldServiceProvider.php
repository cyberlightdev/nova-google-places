<?php

namespace Mknooihuisen\GooglePlaces;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use League\CommonMark\Environment\Environment;

class GooglePlacesFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //TODO: Make this use config files.
        $this->publishes([
            __DIR__.'/google-places.php' => config_path('nova-google-places.php')
        ]);


        $key = config('nova-google-places.api-key');
        if($key === null && !app()->runningInConsole()) {
            throw new \Exception('You must provide a Google Cloud key with access to the places API to use GooglePlaces::make()');
        }

        Nova::serving(function (ServingNova $event) use($key){
            Nova::script('google-places', __DIR__.'/../dist/js/field.js');
            Nova::style('google-places', __DIR__.'/../dist/css/field.css');
            Nova::remoteScript('https://maps.googleapis.com/maps/api/js?key='. $key . '&libraries=places');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
