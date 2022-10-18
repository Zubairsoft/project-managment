<?php

namespace App\Nova\Filters\List;

use App\Models\Board;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class BoardFilter extends Filter
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
        return $query->where('board_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        if ($request->user()->hasRole('admin')) {
            return  Board::pluck('id', 'title');
        }
        return Board::where('user_id', $request->user()->id)->pluck('id', 'title');
    }

    public function name()
    {
        return "Board";
    }
}
