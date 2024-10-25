<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Table name associated with the model
    protected $table = 'appointments';

    // Mass assignable attributes
    protected $fillable = [
        'date_appointment',
        'time_appointment',
        'reason',
        'status',
        'dog_id',
        'professional_id',
    ];

    // Define relationships

    /**
     * Define the relationship with the Dog model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dog_id');
    }

    /**
     * Define the relationship with the Professional model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}