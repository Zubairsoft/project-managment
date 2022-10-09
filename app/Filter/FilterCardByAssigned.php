<?php 
namespace App\Filter;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterCardByAssigned implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->with('assignedUsers')->whereHas('assignedUsers',function(Builder $query)use($value){
            $query->where('user_id',$value);
        });
    }
}