<?php

namespace App\Nova\Filters\Comment;

use App\Models\BoardList;
use Illuminate\Http\Request;
use AwesomeNova\Filters\DependentFilter;

class ListFilter extends DependentFilter
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
   public $name = 'list';

   /**
 * Attribute name of filter. Also it is key of filter.
 *
 * @var string
 */
public $attribute = 'list_id';

public $dependentOf = ['board_id'];





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
        return $query->whereHas('card',function($query)use($value){
            $query->where('list_id',$value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request,array $filters=[])
    {
        
      return  BoardList::when($filters['board_id'],function($query,$value){
            $query->where('board_id',$value);
        })->pluck('name','id');
    }
}
