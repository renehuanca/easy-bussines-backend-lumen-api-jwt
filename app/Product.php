<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categorie;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'quantity',
        'unit_price',
        'total_in_stock',
        'category_id',
        'last_user',
        'is_deleted'
    ];

     /**
     * Get the categorie that owns the product.
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

}
