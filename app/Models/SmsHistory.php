<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    protected $table = 'sms_history';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'subject',
        'message',
        'recipient_count',
        'success_count',
        'failed_count',
        'status',
    ];

    protected $casts = [
        'recipient_count' => 'integer',
        'success_count' => 'integer',
        'failed_count' => 'integer',
        'created_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(SmsDetail::class, 'sms_history_id');
    }
}
