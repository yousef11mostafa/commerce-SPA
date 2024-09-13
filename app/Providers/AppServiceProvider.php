<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        //

        Role::firstOrCreate(['name' => 'user']);
        Role::firstOrCreate(['name' => 'seller']);
        Role::firstOrCreate(['name' => 'admin']);

        


    }
}
