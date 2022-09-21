<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $guard_name ='api';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    #################### Relation ########################

    public  function company()
    {
        return $this->hasOne(Company::class,'owner_id');
    }

    public function companyMember()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    ######################################################

    ################### scope  ###########################
    public function scopeGetEmployees(Builder $query)
    {
    $query->where('company_id',auth()->user()->company_id)->where('id','<>',auth()->user()->id);
    }
    ######################################################
    #################### Accessor ########################

    public function setPasswordAttribute($value)
    {
     return $this->attributes['password']=bcrypt($value);
    }
    ######################################################
}
