<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    // Name of the table associated with the model
    protected $table = 'availability';

    // The attributes that are mass assignable
    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'professional_id',
    ];

    // Declaration of relationships
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}