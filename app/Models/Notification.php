<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Notification;



class Notification extends Model
{
    use HasFactory;

    // Name of table in database
    protected $table = 'notifications';

    // Fields that can be mass assigned
    protected $fillable = [
        'message',
        'date_notification',
        'read',
        'user_id',
    ];

    // Fields that can not be mass assigned

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