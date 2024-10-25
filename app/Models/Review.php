<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Name of the table associated with the model
    protected $table = 'reviews';

    // Attributes that are mass assignable
    protected $fillable = [
        'rating',
        'comment',
        'date_review',
        'professional_id',
    ];

    // Definition of the relations

    /**
     * Define the inverse relationship with the Professional model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}