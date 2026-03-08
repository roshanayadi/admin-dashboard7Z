<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];
}
