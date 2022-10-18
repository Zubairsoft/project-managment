<?php

namespace App\Nova;

use App\Nova\Filters\User\CompanyEmployee;
use App\Nova\Filters\User\CompanyOwner;
use App\Nova\Filters\User\UserActive;
use App\Nova\Lenses\MostUsersHaveBoard;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Metrics\TotalEmployee;
use App\Nova\Metrics\User\NewUsers;
use App\Nova\Metrics\User\UsersPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Vyuldashev\NovaPermission\RoleSelect;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    // public static $tableStyle = 'tight'; // for change table style for resource
    public static $perPageOptions = [15, 25, 50]; // for customize the pagination in the resource

    /**
     * The debounce amount to use when searching this resource.
     *
     * @var float
     */
    public static $debounce = 0.5; // 0.5 seconds it will take 0.5s when searching in the resource


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50)->squared(), // Gravatar doesn't associate with any model

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            // Boolean::make('status','is_active'),
            Badge::make('status', 'activeStatus')->map([
                __('auth.user.block') => 'danger',
                __('auth.user.active') => 'success',
            ]),

            Boolean::make('is_active')
                ->onlyOnForms(),
            Hidden::make('company_id')->default(function () {
                return auth()->user()->company_id;
            })->onlyOnForms(),

            RoleSelect::make('Role', 'roles')
            ->onlyOnDetail()
            ->onlyOnIndex()
            ->canSeeWhen('canView',$this),

            RoleSelect::make('Role', 'roles')
            ->onlyOnForms()->canSeeWhen('canView',$this),

            RoleSelect::make('Role', 'roles')->options('employee')->default(function(){
                return 'employee';
            })->onlyOnForms()->canSee(function(){
              return  auth()->user()->hasRole('owner');
            }),
           


            HasMany::make('Boards', 'boards', 'App\Nova\Board'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            // new NewUsers(),
            // new UsersPerDay(),
            (new NewUsers)->width('1/3')->canSeeWhen('viewUsersCard', $this),
            (new UsersPerDay)->width('full')->canSeeWhen('viewUsersCard', $this),
            new TotalEmployee()
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new UserActive,
            (new CompanyEmployee)->canSeeWhen('filterAllow', $this),
            (new CompanyOwner)->canSeeWhen('filterAllow', $this)
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            (new MostUsersHaveBoard)->canSee(function () {
                return auth()->user()->hasRole('admin');
            })
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->hasRole('admin')) {
            return $query;
        }
        return $query->where('company_id', auth()->user()->company_id);
    }
}
