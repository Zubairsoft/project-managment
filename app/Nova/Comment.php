<?php

namespace App\Nova;

use App\Nova\Filters\Comment\BoardFilter;
use App\Nova\Filters\Comment\CardFilter;
use App\Nova\Filters\Comment\ListFilter;
use App\Nova\Metrics\TotalOfComment;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Comment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Comment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'comment';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','comment',
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
            BelongsTo::make('CommentBy','user','App\Nova\User'),
            Text::make('comment'),
            BelongsTo::make('Card','card','App\Nova\Card'),
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
            (new TotalOfComment())->canSeeWhen('canView',$this)->help('the total of commend at all system')
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
             new BoardFilter,
             new ListFilter,
             new CardFilter
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

        return $query->whereHas('card',function($query){
          $query->whereHas('list',function($query){
            $query->whereHas('board',function($query){
                $query->where('user_id',auth()->user()->id);
            });
          });
        });
    }
}
