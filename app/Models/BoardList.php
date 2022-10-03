<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardList extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_name',//todo only use name we know  its name of lis
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

}
