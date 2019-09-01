<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable =[
      'ac_id','amount','start_date','end_date'

    ];


    function account(){
        return $this->belongsTo('App\Account');
    }

}
