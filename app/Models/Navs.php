<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model
{
    protected $table = 'navs';

    protected $fillable = ['type', 'name', 'url', 'isShow', 'isTarget', 'sort'];

    protected $dates = ['created_at', 'updated_at'];

    const NAVS_POSITIONS = [
        '顶部',
        '底部',
    ];

    const NAVS_SHOW = 1;
    const NAVS_NOT_SHOW = 0;
}
