<?php

namespace App\Nova;

use App\Nova\Filters\Card\AssignedUsers;
use App\Nova\Filters\Card\Board;
use App\Nova\Filters\Card\CardList;
use App\Nova\Filters\Card\Priority;
use App\Nova\Filters\Card\Tag;
use App\Nova\Metrics\TotalCard;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Card extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Card::class;

    public static $displayInNavigation = true;


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
        'id','title','description','priorityStatus'
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
            Text::make('title')->rules('required')->sortable(),
            Text::make('description')->sortable(),
            BelongsTo::make('List','list','App\Nova\BoardList'),
            Badge::make('Priority','PriorityStatus')->map([
                __('priority.high')=>'danger',
                __('priority.medium')=>'warning',
                __('priority.low')=>'info',
            ])->sortable(),
            HasMany::make('Tags','assignedTags','App\Nova\Tag'),
            BelongsToMany::make('AssignedUsers','assignedUsers','App\Nova\User')

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
            (new TotalCard),
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
            new Board,
            new CardList,
            new Priority,
            new AssignedUsers,
            new Tag,
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

    public static function uriKey()
    {
        return "list_card";
    }
}
