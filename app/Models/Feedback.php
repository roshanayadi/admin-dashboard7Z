<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'name',
        'email',
        'feedback',
        'rating',
        'ip_address',
        'user_agent',
        'approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }
}
