<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'description',
        'list_id',
        'priority',
    ];

    const PRIORITY=[1,2,3];


    ########################## Relation #############################
    public function list()
    {
     return $this->belongsTo(BoardList::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'members','card_id','user_id')->withTimestamps();

    }

    public function comments()
    {
     return $this->hasMany(Comment::class);
    }
    #################################################################

    ########################### Scope ###############################
 

    #################################################################

    ########################## Accessor #############################
    public function getPriorityAttribute($value)
    {
        if ($value===1) {
            return __('priority.high');
        }elseif($value===2){
           return __('priority.medium');
        }else{
            return __('priority.low');

        }

    }
    public function getDescriptionAttribute($value)
    {
      return  $value==null?__('response.data.null',['attribute'=>'description']):$value;
    }
    #################################################################

}
