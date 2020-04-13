<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
     public function getBmiAttribute()
    {
        return ($this->qty * $this->price);
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($mymodel) {
            $mymodel->total_price = $mymodel->qty * $mymodel->price;
        });
        self::created(function ($model) {
            $model->total_price = $model->qty * $model->price;
        });
    }
}
