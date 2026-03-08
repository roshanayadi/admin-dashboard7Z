<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
