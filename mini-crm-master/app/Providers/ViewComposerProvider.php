<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use KgBot\LaravelLocalization\Facades\ExportLocalizations;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function (\Illuminate\View\View $view) {
            return $view->with([
                    'messages' => ExportLocalizations::export()
                                                     ->toFlat(),
            ]);
        });
    }
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
