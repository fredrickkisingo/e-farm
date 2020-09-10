<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
        //Creates relationship between a farmer and products
        //a user has many posts
     public function posts(){
        return $this->hasMany('App\Post');
      }
      //a user has many carts
      public function carts(){
          return $this->hasMany('App\Cart');
      }
      public function purchases(){
        return $this->hasMany('App\Purchase');
      }

     public function Stk_push_payments(){
        return $this->hasMany('App\Stk_push_payments');
      }
    }

