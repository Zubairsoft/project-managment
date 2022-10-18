<?php

namespace App\Nova\Filters\User;

use App\Models\Company;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class CompanyEmployee extends Filter
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
        return $query->whereHas('companyMember',function($query)use($value){
            $query->where('id',$value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        // return [];
     return   Company::get()->pluck('id','name');
    }

    public function name()
    {
        return "Company";
    }
}
