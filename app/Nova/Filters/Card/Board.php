<?php

namespace App\Nova\Filters\Card;

use App\Filter\FilterCardByBoard;
use App\Models\Board as ModelsBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Filters\Filter;
use AwesomeNova\Filters\DependentFilter;


class Board extends DependentFilter
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
   public $name = 'board';

   /**
 * Attribute name of filter. Also it is key of filter.
 *
 * @var string
 */
public $attribute = 'board_id';




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
        $board=new FilterCardByBoard();
      
        return $board($query,$value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request, array $filters = [])
    {
        if (auth()->user()->hasRole('admin')) {
            return ModelsBoard::pluck('title','id');
        }

        return ModelsBoard::where('user_id',auth()->user()->id)->pluck('title','id');

    }
}
