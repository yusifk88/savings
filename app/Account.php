<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [

        'title',
        'fname',
        'lname',
        'sex',
        'hometown',
        'dob',
        'address',
        'phone',
        'bank',
        'accno',
        'occupation',
        'passport',
        'email'

    ];


    function loans(){
        return $this->hasMany('App\Loan');
    }


    function payments(){
        return $this->hasMany('App\Payment');
    }




}
