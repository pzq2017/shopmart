<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberGrade extends Model
{
    protected $table = 'member_grade';

    protected $fillable = ['name', 'icon', 'min_score', 'max_score', 'rebate'];

    protected $dates = ['created_at', 'updated_at'];
}
