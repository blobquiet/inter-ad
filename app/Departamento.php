<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departamento';


    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
