<?php

namespace App\Nova\Filters\Card;

use App\Filter\FilterCardByPriority;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Priority extends Filter
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
         $priority=new FilterCardByPriority();
         return $priority($query,$value,"priority");
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            __('priority.high')=>1,
            __('priority.medium')=>2,
            __('priority.low')=>3
        ];
    }

 
}
