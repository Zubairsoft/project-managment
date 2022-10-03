<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id'
        //todo: use laravel/pint
    ];

    //todo: use laravel/pint

    ################ Relation #####################
    public function owner()
    {
     return $this->belongsTo(User::class,'owner_id');
    }

    public function users() //todo: employees ??
    {
        return $this->hasMany(User::class);
    }

    ###############################################
}
