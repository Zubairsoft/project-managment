<?php

namespace App\Providers;

use App\Models\Board;
use App\Models\Company;
use App\Models\User;
use App\Nova\Metrics\AllCompany;
use App\Nova\Metrics\AllCompanyBoard;
use App\Nova\Metrics\BoardFlow;
use App\Nova\Metrics\TotalBoard;
use App\Nova\Metrics\TotalCard;
use App\Nova\Metrics\TotalEmployee;
use App\Nova\Metrics\User\NewUsers;
use App\Nova\Metrics\User\UsersPerDay;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            // new Help,
            (new NewUsers)->width('1/3')->help("total users in system by specific period ")
            ->canSeeWhen('viewUsersCard',User::class),
            (new AllCompany)->help("total all companies in system")->canSeeWhen('viewCompanyCard',Company::class),
            (new BoardFlow)->help("board flow in the system")->width('full')->canSee(function(){
                return auth()->user()->hasRole('admin');
            }),
            (new UsersPerDay)->width('full')->canSeeWhen('viewUsersCard',$this),
            (new TotalBoard)->canSeeWhen('showTotalCard',Board::class)->help('the total of board in the system'),
            (new TotalCard)->canSee(function(){
                return auth()->user()->hasRole('admin');
            }) ,

            (new AllCompanyBoard)->help("your own board in the system"),
            new TotalEmployee
            
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Gate::define('viewNova',function( $user ){
            if ($user->hasRole('admin')) {
                return true;
            }
            return false;

        });
    }
    
}
