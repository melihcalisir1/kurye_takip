<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Admin yetkisi
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        // Restaurant yetkisi
        Gate::define('restaurant', function ($user) {
            return $user->role === 'restaurant';
        });

        // Kurye yetkisi
        Gate::define('courier', function ($user) {
            return $user->role === 'courier';
        });
    }
} 