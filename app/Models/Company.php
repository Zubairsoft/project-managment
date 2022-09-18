<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'owner_name',
       
    ];

    

    ################ Relation #####################
    public function user()
    {
     return $this->hasMany(User::class);
    }
    ###############################################
    ##################### Accessor ################
    public function setPasswordAttribute($value)
    {
     return $this->attributes['password']=bcrypt($value);
    }
}
