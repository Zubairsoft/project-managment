<?php

namespace App\Providers;

use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

use App\Models\Company;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\CompanyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Company' => 'App\Policies\CompanyPolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
        'App\Models\Board'   => 'App\Policies\BoardPolicy',
        'App\Models\User'    => 'App\Policies\EmployeePolicy',
        'App\Models\Card'    => 'App\Policies\CardPolicy',

        Company::class=>CompanyPolicy::class,
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
 

        //
    }
}
