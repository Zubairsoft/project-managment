<?php

namespace App\Models;
use Spatie\Image\Manipulations; // new added
use Spatie\MediaLibrary\MediaCollections\Models\Media;//new added
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable=[
        'title',
        'description',
        'list_id',
        'priority',
    ];

    const PRIORITY=[1,2,3];

    ########################################################//todo delete or add comment when will be used
    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')
    //         ->width(368)
    //         ->height(232)
    //         ->sharpen(10)
    //         ->quality(60)
    //         ->performOnCollections('cards');

    // }


    ########################## Relation #############################
    public function list()
    {
     return $this->belongsTo(BoardList::class);
    }

    public function users()//todo assignedUsers ??
    {
        return $this->belongsToMany(User::class,'members','card_id','user_id')->withTimestamps();

    }
    //todo Creator  Relation ??

    public function comments()
    {
     return $this->hasMany(Comment::class);
    }
    #################################################################

    ########################### Scope ###############################


    #################################################################

    ########################## Accessor #############################
    public function getPriorityAttribute($value)//todo :why you overrider main Attr ?
    {
        //todo : switch  is better
        if ($value===1) {
            return __('priority.high');
        }elseif($value===2){
           return __('priority.medium');
        }else{
            return __('priority.low');

        }

    }
    public function getDescriptionAttribute($value)//todo :why you overrider main Attr ?
    {
      return  $value==null?__('response.data.null',['attribute'=>'description']):$value;
    }
    #################################################################
    ##################### scope #####################################
    public function  scopeAllCardWithSortWithPriority(Builder $query,$list_id)
    {
    return $query->where('list_id',$list_id)->orderBy('priority');
    }

    #################################################################

}
