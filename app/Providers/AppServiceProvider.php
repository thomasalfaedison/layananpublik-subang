<?php

namespace App\Providers;

use App\Constants\LayoutConstant;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        
        if (!class_exists('LayoutConstant', false)) {
            class_alias(LayoutConstant::class, 'LayoutConstant');
        }

        if (!class_exists('Form', false)) {
            class_alias(\App\Facades\Form::class, 'Form');
        }
    }
}
