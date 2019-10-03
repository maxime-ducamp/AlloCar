<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Journey' => 'App\Policies\JourneyPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
        'Illuminate\Notifications\DatabaseNotification' => 'App\Policies\NotificationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
