<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'action',
        'details',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public static function log(string $type, string $action, ?string $details = null): self
    {
        return self::create([
            'type' => $type,
            'action' => $action,
            'details' => $details,
        ]);
    }
}
