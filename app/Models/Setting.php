<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    /**
     * Return the setting matching the given key
     **/
    public static function retrieve($key, $default = null)
    {
        $setting = self::whereKey($key)->first();

        if (is_null($setting)) {
            return $default;
        }

        if (is_array($value = unserialize($setting->value))) {
            return collect($value);
        }

        return $value;
    }

    public static function store($key, $value)
    {
        return self::create([
            'key'   => $key,
            'value' => serialize($value),
        ]);
    }
}
