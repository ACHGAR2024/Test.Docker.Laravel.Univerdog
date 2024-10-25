<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    // Name of the table associated with the model
    protected $table = 'dogs';

    // The attributes that are mass assignable
    protected $fillable = [
        'name_dog',
        'breed',
        'birth_date',
        'weight',
        'sex',
        'medical_info',
        'qr_code',
        'user_id',
    ];

    // Declaration of relations

    /**
     * Get the appointments associated with the dog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'dog_id');
    }

    /**
     * Get the photos associated with the dog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(DogPhoto::class, 'dog_id');
    }

    /**
     * Define the relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}