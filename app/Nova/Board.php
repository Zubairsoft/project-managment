<?php

namespace App\Nova;

use App\Models\Board as ModelsBoard;
use App\Nova\Filters\Board\CompanyFilter;
use App\Nova\Metrics\AllCompanyBoard;
use App\Nova\Metrics\BoardListsTotal;
use App\Nova\Metrics\oardListsTotal;
use App\Nova\Metrics\TotalBoard;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
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

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

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
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('title','title')->sortable(),
            HasMany::make('lists','lists','App\Nova\BoardList'),
            BelongsTo::make('Creator','creator','App\Nova\User')->canSeeWhen('canView',$this),

            
            Hidden::make('User', 'user_id')->default(function () {
                return auth()->user()->id;
            }),


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
            new AllCompanyBoard,
            (new BoardListsTotal())->onlyOnDetail()
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
            (new CompanyFilter)->canSeeWhen('canView',$this)
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
        return [];
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->hasRole('admin')) {
            return $query;
        }
        return $query->where('user_id',auth()->user()->id);
    }
}
