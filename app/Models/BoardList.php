<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'board_id',

    ];

    ########### Relation ####################
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class,'list_id');
    }
    ########################################
    ############ scope #####################
    public function scopeOwnBoard(Builder $query,Board $board)
    {
    $query->where('board_id',$board->id);
    }
    public function scopeCardPriority(Builder $query,$value)
    {
    $query->whereHas('cards',function(Builder $query)use($value){
        $query->where('priority', $value);
    });
    }
 


    ########################################

}
