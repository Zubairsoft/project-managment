<?php
 namespace App\Sort;
use Illuminate\Database\Eloquent\Builder;

class SortCardByGroupingList implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'ASC' : 'DESC';


        $query->whereHas('list',function($query){
            $query->groupBy('id')->with('cards');
        }
        );
    }
}