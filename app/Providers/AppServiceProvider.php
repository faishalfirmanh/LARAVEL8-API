<?php

namespace App\Providers;

use App\Repository\K1\Category\CategoryRepository;
use App\Repository\K1\Category\CategoryRepositoryImplement;
use App\Service\K1\Category\CategoryService;
use App\Service\K1\Category\CategoryServiceImplement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //fungsi bind untuk mengikat  class terkait, agar bisa dikenali oleh laravel dan bisa diakses
        //category
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImplement::class); //1
        $this->app->bind(CategoryService::class, CategoryServiceImplement::class);//2

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
