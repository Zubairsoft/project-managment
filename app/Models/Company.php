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
       
    ];

    

    ################ Relation #####################
    public function owner()
    {
     return $this->belongsTo(User::class,'owner_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    ###############################################
}
