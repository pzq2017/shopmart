<?php

namespace App\Models;

use App\Models\Roles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staffs extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'staffs';

    protected $fillable = ['loginName', 'password', 'secretKey', 'staffName', 'staffNo', 'staffPhoto', 'staffRoleId', 'workStatus', 'staffStatus'];

    protected $hidden = ['password', 'secretKey'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'lastTime'];

    const SUPER_USER = -1;		//超级用户

    const WORKING = 1;			//状态在职

    const LEAVE_WORK = 0;		//状态离职

    public function role()
    {
    	return $this->belongsTo(Roles::class, 'staffRoleId');
    }
}
