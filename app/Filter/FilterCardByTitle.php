<?php 
namespace App\Filter;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterCardByTitle implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('title','like','%'.$value.'%');
    }
}