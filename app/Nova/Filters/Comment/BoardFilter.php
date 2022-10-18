<?php

namespace App\Nova\Filters\Comment;

use App\Models\Board;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use AwesomeNova\Filters\DependentFilter;

class BoardFilter extends DependentFilter
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
        return $query->whereHas('card', function ($query) use($value) {
            $query->whereHas('list', function ($query) use($value) {
                $query->where('board_id', $value);
            });
        });
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
            return Board::pluck('title', 'id');
        }
        return Board::where('user_id', auth()->user()->id)->pluck('title', 'id');
    }
}
