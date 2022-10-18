<?php 
namespace App\Filter;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterCardByBoard implements Filter
{
    public function __invoke(Builder $query, $value, string $property='board')
    {
        $query->whereHas('list',function($query) use($value){
         $query->where('board_id',$value);
       });
    }
}