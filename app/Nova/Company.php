<?php

namespace App\Nova;

use App\Models\Comment;
use App\Models\Company as ModelsCompany;
use App\Nova\Actions\Company\ToggleStatus;
use App\Nova\Filters\Company\Status;
use App\Nova\Metrics\AllCompany;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Company extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Company::class;

    public static $polling = false;
  //public static  $pollingInterval = 5;
   public static $showPollingToggle = false; //  this will show toggle bottom for fetching data 
    public static $preventFormAbandonment = true;// set the important fill form before leaving
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    public static $with=['owner','employees'];


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
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
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('name')->sortable(),
            BelongsTo::make('Owner','owner','App\Nova\User'),
            HasMany::make('Employees','employees','App\Nova\User'),
            Badge::make('status','companyStatus')->map([
                __('auth.user.active')=>'success',
                __('auth.user.block')=>'danger'
            ])
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
            (new AllCompany)->canSeeWhen('viewCompanyCard',$this),

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
            (new Status)
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
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new ToggleStatus)
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->hasRole('admin')) {
            return $query;
        }
        return $query->where('owner_id',auth()->user()->id);
    }
}
