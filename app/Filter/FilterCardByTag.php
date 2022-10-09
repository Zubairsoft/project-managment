<?php 
namespace App\Filter;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterCardByTag implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->with('assignedTags')->whereHas('assignedTags',function(Builder $query)use($value){
            $query->where('name',$value);
        });
    }
}