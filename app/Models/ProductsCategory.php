<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCategory extends Model
{
    use HasFactory;

    // Table name associated with the model
    protected $table = 'products_category';

    // Mass assignable attributes
    protected $fillable = [
        'name_product_cat',
    ];

    // Relationships declaration

    /**
     * Get the products associated with this product category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'products_category_id');
    }
}