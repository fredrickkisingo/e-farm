<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    //table name
    protected $table = 'purchases';

    public function user() {
        return $this->belongsTo('App\User');
    }

   

}
