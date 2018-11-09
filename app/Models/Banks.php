<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banks extends Model
{
    use SoftDeletes;

    protected $table = 'banks';

    protected $fillable = ['name', 'status', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
