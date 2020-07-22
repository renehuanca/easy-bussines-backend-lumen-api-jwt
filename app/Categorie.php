<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_user',
        'state'
    ];

}
