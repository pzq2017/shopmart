<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'member';

    protected $fillable = ['loginAccount', 'loginPwd', 'nickname', 'realname', 'avatar', 'sex', 'birthday', 'mobile', 'email', 'qq'];

    protected $hidden = ['loginPwd'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public static function isExistAccount($account)
    {
        return self::where('loginAccount', $account)->count() > 0 ? true : false;
    }

    public static function isExistMobile($mobile)
    {
        return self::where('mobile', $mobile)->count() > 0 ? true : false;
    }

    public static function isExistEmail($email)
    {
        return self::where('email', $email)->count() > 0 ? true : false;
    }
}
