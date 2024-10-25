<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    // Table name associated with the model
    protected $table = 'professionals';

    // Fillable attributes
    protected $fillable = [
        'company_name',
        'description_pro',
        'rates',
        'user_id',
        'place_id',
    ];

    // Define relationships

    /**
     * Get the availabilities associated with the professional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'professional_id');
    }
    /**
     * Get the specialties associated with the professional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specialties()
    {
        return $this->hasMany(Specialty::class, 'professional_id');
    }

    /**
     * Get the appointments associated with the professional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'professional_id');
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

    /**
     * Define the relationship with the Place model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}