<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'is_active'
    ];


    ################ Relation #####################
    public function owner()
    {
     return $this->belongsTo(User::class,'owner_id');
    }

    public function employees() 
    {
        return $this->hasMany(User::class);
    }

    ###############################################
    ############## Accessor  ######################
    public function getCompanyStatusAttribute(){
      return  $this->is_active==true?__('auth.user.active'):__('auth.user.block');
    }
    ###############################################
}
