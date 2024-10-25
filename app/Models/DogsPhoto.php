<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogsPhoto extends Model
{
    use HasFactory;

    // Table name associated with the model
    protected $table = 'dogs_photos';

    // The attributes that are mass assignable
    protected $fillable = [
        'dog_id',
        'photo_name_dog',
    ];

    // Declaration of relationships

    /**
     * Define the inverse relationship with the Dog model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dog_id');
    }
}