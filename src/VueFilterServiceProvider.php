<?php

namespace Saeed\VueFilter;

use Illuminate\Support\ServiceProvider;


class VueFilterServiceProvider extends ServiceProvider
{
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/components/persian/' => resource_path('/js/components'),
                __DIR__ . '/asset/VueFilter/persian' => public_path('/css/VueFilter/'),

            ], 'VueFilter-Persian');
            $this->publishes([
                __DIR__ . '/components/english/' => resource_path('/js/components'),
                __DIR__ . '/asset/VueFilter/english' => public_path('/css/VueFilter/'),

            ], 'VueFilter-English');
        }

    }

    public function register()
    {


    }



}