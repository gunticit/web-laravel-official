<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        $modulePaths = app_path('Modules');
        
        if(file_exists($modulePaths)) {
            $modules = scandir($modulePaths);
            foreach($modules as $module) {
                if(is_dir($modulePaths . '/' . $module) && $module !== '.' && $module !== '..') {
                    View::addNamespace($module, $modulePaths . '/' . $module . '/Views');
                }
            }
        }
    }
}
