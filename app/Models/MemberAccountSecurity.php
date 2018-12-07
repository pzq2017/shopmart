<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberAccountSecurity extends Model
{
    protected $table = 'member_account_security';

    protected $fillable = ['memberId', 'type', 'flag', 'status'];

    protected $dates = ['created_at'];

    const SECURITY_TYPE_PASSWORD = 1;                   //登录密码强度
    const SECURITY_TYPE_MOBILE = 2;                     //手机号绑定
    const SECURITY_TYPE_EMAIL = 3;                      //邮箱绑定
    const SECURITY_TYPE_REAL_NAME = 4;                  //实名认证
    const SECURITY_TYPE_PAYMENT_PASSWORD = 5;           //支付密码设置

    const SECURITY_TYPES = [
        self::SECURITY_TYPE_PASSWORD,
        self::SECURITY_TYPE_MOBILE,
        self::SECURITY_TYPE_EMAIL,
        self::SECURITY_TYPE_REAL_NAME,
        self::SECURITY_TYPE_PAYMENT_PASSWORD
    ];
}
