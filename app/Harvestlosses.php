<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harvestlosses extends Model
{
    //table name
    protected $table = 'harvestlosses';
    //primary key
    public $primaryKey = 'id';
    //timestamps
    public $timestamps = true;
}
