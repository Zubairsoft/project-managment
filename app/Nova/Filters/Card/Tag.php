<?php

namespace App\Nova\Filters\Card;

use App\Filter\FilterCardByTag;
use App\Models\Tag as ModelsTag;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Tag extends Filter
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
        $tag_filter=new FilterCardByTag();
        return $tag_filter($query,$value,'tag');
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return ModelsTag::pluck('id','name');
    }
}
