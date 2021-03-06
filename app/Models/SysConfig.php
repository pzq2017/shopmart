<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysConfig extends Model
{
    protected $table = 'sys_configs';

    protected $fillable = ['code', 'value'];

    protected $dates = ['created_at', 'updated_at'];

    public static function getValue($field)
    {
        return self::where('code', $field)->value('value');
    }
}
