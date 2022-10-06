<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'color',
        'card_id',
        'creator_id'
    ];

    public Const COLOR=[
        'red','green','blue','yellow',
        'gray','black','white','orange',
        'indigo','violet','purple','pink',
        'silver','gold','beige','brown'
    ];

    ########################## Relation ####################

    public function card()
    {
     return $this->belongsTo(Card::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    ########################################################
}
