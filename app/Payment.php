<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =[
        'ac_id','amount','purpose','payment_date'
    ];


    function account(){
        return $this->belongsTo('App\Account');
    }
}
