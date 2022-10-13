<?php

namespace App\Nova;

use App\Nova\Metrics\AllCompanyBoard;
use App\Nova\Metrics\TotalBoard;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Board extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Board::class;

    // public static $group = 'Admin';  // this static property for make group for board with name= Admin in sidebar;
    // public static $with = ['user'];  // this static property for edger loading with user ;
    // public static $polling=true;// this will automatically fetch data when the model updated --real time
   // public static $pollingInterval = 5; //property on your resource class with the number of seconds Nova should wait before fetching new resource records:
    //public static $showPollingToggle = true; //  this will show toggle bottom for fetching data 
    //public static $preventFormAbandonment = true;// set the important fill form before leaving

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'Boards';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title'
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
            ID::make(__('ID'), 'id')->sortable()->canSeeWhen('show',$this),
            Text::make('title','title')->sortable()->canSeeWhen('show',$this),
            // Hidden::make('User', 'user_id')->default(function () {
            //     return auth()->user()->id;
            // }),


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
            (new TotalBoard)->canSeeWhen('showTotalCard',$this),
            new AllCompanyBoard(),

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
        return [];
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
        return [];
    }
}
