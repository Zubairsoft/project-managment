<?php

namespace App\Nova\Filters\Comment;

use App\Models\Card;
use Illuminate\Http\Request;
use AwesomeNova\Filters\DependentFilter;

class CardFilter extends DependentFilter
{

      /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'awesome-nova-dependent-filter';

    /**
     * Name of filter.
     *
     * @var string
     */
    public $name = 'card';

    /**
     * Attribute name of filter. Also it is key of filter.
     *
     * @var string
     */
    public $attribute = 'card_id';

    public $dependentOf=['list_id'];




    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('card_id',$value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request,array $filters=[])
    {
        return Card::when($filters['list_id'],function($query,$value){
            $query->where('list_id',$value);
        })->pluck('title','id');
    }
}
