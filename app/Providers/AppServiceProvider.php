<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        DB::listen(function ($query) {
            \Log::info($query->sql, ['Bindings' => $query->bindings, 'Time' => $query->time]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $validatorFiles = scandir(app_path('Validators'));

        foreach ($validatorFiles as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                $class = 'App\\Validators\\' . pathinfo($file, PATHINFO_FILENAME);
                $class::extendValidator();
            }
        }
    }
}
