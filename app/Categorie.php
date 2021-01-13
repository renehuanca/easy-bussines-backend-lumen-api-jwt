<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

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
        'is_deleted'
    ];

    /**
     * Get the products for the Categories.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
