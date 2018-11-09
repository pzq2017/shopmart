<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdPositions extends Model
{
    use SoftDeletes;

    protected $table = 'ad_positions';

    protected $fillable = ['type', 'name', 'width', 'height', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    const TYPE_PC_PLATFORM = 1;

    public function scopeOrderBySort($query, $sort='desc')
    {
        return $query->orderBy('sort', $sort);
    }

    public function ads()
    {
        return $this->hasMany(Ads::class, 'posid');
    }
}
