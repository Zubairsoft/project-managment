<?php

namespace App\Nova\Filters\Card;

use App\Filter\FilterCardByAssigned;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class AssignedUsers extends Filter
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
        $assigned_user=new FilterCardByAssigned();

        return $assigned_user($query,$value,'assigned');
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            return User::where('id','<>',auth()->user()->id)->pluck('id','name');
        }

        return User::where('company_id',auth()->user()->company_id)->pluck('id','name');
    }
}
