<?php

namespace App\Providers;

use App\Models\NewsletterAdmin;
use App\Models\Theme;
use App\Policies\ThemePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Theme::class => ThemePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('viewMailcoach', function ($user = null) {
            if (! $user) {
                return false;
            }

            return get_class($user) === NewsletterAdmin::class;
        });
    }
}
