<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Name of the table associated with the model
    protected $table = 'products';

    // Fillable attributes
    protected $fillable = [
        'name_product',
        'description_product',
        'price',
        'affiliation_link',
        'products_category_id',
    ];

    // Relationships declaration

    /**
     * Define the relationship with the ProductsCategory model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductsCategory::class, 'products_category_id');
    }

    /**
     * Get the photos associated with this product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(ProductsPhoto::class, 'product_id');
    }
}