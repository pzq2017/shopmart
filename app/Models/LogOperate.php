<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogOperate extends Model
{
    protected $table = 'log_operate';

    protected $fillable = ['staffId', 'menuId', 'desc', 'accessUrl', 'content', 'ip'];

    public function staff()
    {
        return $this->belongsTo(Staffs::class, 'staffId');
    }
}
