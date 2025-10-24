<?php

namespace LaravelHtml\Html\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelHtml\Html\Html;

class HtmlServiceProvider extends ServiceProvider
{
    private $facades = [
        'infureal_html' => Html::class,
    ];

    public function register()
    {

        foreach ($this->facades as $abstract => $facade)
            $this->app->bind($abstract, function () use ($facade) {
                return new $facade();
            });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
