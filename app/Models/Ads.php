<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ads extends Model
{
    use SoftDeletes;

    protected $table = 'ads';

    protected $fillable = ['type', 'posid', 'name', 'image_path', 'url', 'start_date', 'end_date', 'sort'];

    protected $dates = ['publish_date', 'created_at', 'updated_at', 'deleted_at'];

    public function ad_positions()
    {
        return $this->belongsTo(AdPositions::class, 'posid');
    }
}
