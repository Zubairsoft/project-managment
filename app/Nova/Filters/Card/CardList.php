<?php

namespace App\Nova\Filters\Card;

use App\Filter\FilterCardByList;
use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use AwesomeNova\Filters\DependentFilter;

class CardList extends DependentFilter
{
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

    
    
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'awesome-nova-dependent-filter';

    public $dependentOf = ['board_id'];

    public $hideWhenEmpty = true;

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
    public function options(Request $request, array  $filters=[])
    {
       if (auth()->user()->hasRole('admin')) {
        return BoardList::when($filters['board_id'],function($query,$value){
            $query->where('board_id', $value);
           })->pluck('name','id');
       }

       return BoardList::when($filters['board_id'],function($query,$value){
        $query->whereHas('board',function($query) use($value){
         $query->where('id',$value)->where('user_id',auth()->user()->id);
        });
       })->pluck('name','id');
    }
}
