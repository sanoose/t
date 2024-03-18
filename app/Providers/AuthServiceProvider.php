<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;


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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        
        Gate::define("user_create" , function ($user) {
            return $user->role->user_create  == "true" ;
        })  ;

        Gate::define("user_show" , function ($user) {
            return $user->role->user_edit  == "true" ;
        })  ;

        Gate::define("user_edit" , function ($user) {
            return $user->role->user_edit  == "true" ;
        })  ;

        Gate::define("user_delete" , function ($user) {
            return $user->role->user_delete  == "true" ;
        })  ;



    }
}
