<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsDetail extends Model
{
    protected $table = 'sms_details';

    public $timestamps = false;

    protected $fillable = [
        'sms_history_id',
        'recipient',
        'status',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function history()
    {
        return $this->belongsTo(SmsHistory::class, 'sms_history_id');
    }
}
