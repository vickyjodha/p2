<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Person  extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'person';
    function user(){
        return $this->hasOne('App\Models\User');
    }
    function address(){
        return $this->belongsToMany(Address::class, 'person_address', 'person_id', 'address_id');
    }

}
