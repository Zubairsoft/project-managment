<?php

namespace App\Models;

use Spatie\Image\Manipulations; // new added
use Spatie\MediaLibrary\MediaCollections\Models\Media; //new added
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'list_id',
        'priority',
    ];

    const PRIORITY = [1, 2, 3];

    // $limit static variable for determine the limit of card paginate 
    public static $limit=20;




    ########################## Relation #############################
    public function list()
    {
        return $this->belongsTo(BoardList::class);
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'members', 'card_id', 'user_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function assignedTags()
    {
        return $this->hasMany(Tag::class);
    }
    #################################################################

    ########################### Scope ###############################
    public function scopeCardPriority(Builder $query,$value)
    {
    $query->where('priority',$value);
    }

    #################################################################

    ########################## Accessor #############################
    public function getPriorityStatusAttribute()
    {
        switch ($this->priority) {
            case 1:
                return __('priority.high');
                break;
            case 2:
                return __('priority.medium');
                break;

            default:
                return __('priority.low');
                break;
        }
    }
    #################################################################
    ##################### scope #####################################
    public function  scopeAllCardWithSortWithPriority(Builder $query, $list_id)
    {
        return $query->where('list_id', $list_id)->orderBy('priority');
    }

    #################################################################

}
