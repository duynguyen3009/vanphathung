<?php


namespace App\Helpers\Grid;


use App\Helpers\Grid\Components\SearchForm;
use App\Helpers\Grid\Components\SearchVehicle;
use App\Helpers\Grid\Components\ResultTable;
use App\Helpers\Grid\Components\AjaxList;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class GridServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'grid');

        $this->loadViewComponentsAs('grid', [
            SearchForm::class,
            ResultTable::class,
            AjaxList::class,
            SearchVehicle::class
        ]);
    }
}