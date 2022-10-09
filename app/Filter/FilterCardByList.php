<?php 
namespace App\Filter;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterCardByList implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('list_id',$value);
    }
}