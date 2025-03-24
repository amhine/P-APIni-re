<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Interface\UserInterface;
use App\Repository\UserRepository;
use App\Repository\Interface\CommandeInterface;
use App\Repository\CommandeRepository;
use App\Repository\Interface\plantesInterface;
use App\Repository\plantesRepository;
use App\Repository\Interface\CategorieInterface;
use App\Repository\categorieRepository;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    

public function register()
{
    $this->app->bind(UserInterface::class, UserRepository::class);
    $this->app->bind(CommandeInterface::class, CommandeRepository::class);
    $this->app->bind(plantesInterface::class, plantesRepository::class);
    $this->app->bind(CategorieInterface::class, categorieRepository::class);
}


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
