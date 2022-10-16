<?php

namespace App\Nova\Filters\Card;

use App\Filter\FilterCardByList;
use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Filters\Filter;

class CardList extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

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
        $list =new FilterCardByList();
        return $list($query,$value,'list');
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
    //     if (isset($_REQUEST['Board-filter-select'])) {
    //   return BoardList::where('board_id',1)->pluck('id','name');
    //     }
       return BoardList::get()->pluck('id','name');
    }
}
