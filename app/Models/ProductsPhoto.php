<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsPhoto extends Model
{
    use HasFactory;

    // Table name associated with the model
    protected $table = 'products_photos';

    // Fillable attributes
    protected $fillable = [
        'photo_name_product',
        'product_id',
    ];

    // Declare relationships

    /**
     * Define the relationship with the Product model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}