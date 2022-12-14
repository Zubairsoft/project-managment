<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Comment extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable=[
        'comment',
        'user_id',
        'card_id'
    ];

    public function registerMediaCollections(): void
    { 
    $this->addMediaCollection('comments')->singleFile();
    }
    #################### Relation ############################################

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    ##########################################################################
}
