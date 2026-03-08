<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $primaryKey = 'setting_key';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'setting_key',
        'setting_value',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    public static function getValue(string $key, $default = null): ?string
    {
        $setting = self::find($key);
        return $setting ? $setting->setting_value : $default;
    }

    public static function setValue(string $key, ?string $value): void
    {
        self::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value]
        );
    }
}
