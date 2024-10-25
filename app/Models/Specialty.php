<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    // Table name associated with the model
    protected $table = 'specialty';  // Make sure it's 'specialty'

    // Mass-assignable attributes
    protected $fillable = [
        'name_speciality',
        'professional_id',
    ];

    // Define relationships

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