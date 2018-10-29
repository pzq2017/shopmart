<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messages extends Model
{
    use SoftDeletes;

    protected $table = 'messages';

    protected $fillable = ['type', 'sendUserId', 'content', 'status'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    const ADMIN_CREATED = 0;
    const SYSTEM_CREATED = 1;

    public function staff()
    {
        return $this->belongsTo(Staffs::class, 'sendUserId');
    }
}
