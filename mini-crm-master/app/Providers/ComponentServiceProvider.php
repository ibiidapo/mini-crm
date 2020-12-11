<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::component('components.alert', 'alert');
    }
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
