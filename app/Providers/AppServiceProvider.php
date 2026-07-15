<?php

namespace App\Providers;

use App\Models\Animal;
use App\Models\Enclosure;
use App\Policies\AnimalPolicy;
use App\Policies\EnclosurePolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

     protected $policies = [
        Animal::class => AnimalPolicy::class,
        Enclosure::class => EnclosurePolicy::class
    ];

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
        //
    }
}
