<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',

    ];
    /**
     * this limit static variable for determine the limit for boards in paginate in board
     */
    public static $limit=20;


    ################ Relation ####################
    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function lists()
    {
        return $this->hasMany(BoardList::class,);// use laravel/pint
    }
    ##############################################
    ############ scopes ##########################
    public function scopeAuthBoards(Builder $query)
    {
        $id=auth()->user()->id;
        $query->where('user_id',$id);
    }
    ##############################################
}
