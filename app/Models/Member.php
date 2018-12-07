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

    /**
     * 创建用户安全等级信息
     * @param array $params
     */
    public function createAccountSecurity($params=[])
    {
        $security_types = MemberAccountSecurity::SECURITY_TYPES;
        foreach ($security_types as $security_type) {
            $save_data = [];
            if (isset($params['password_level']) && $security_type == MemberAccountSecurity::SECURITY_TYPE_PASSWORD) {
                $save_data['flag'] = $params['password_level'];
                $save_data['status'] = 1;
            } elseif (isset($params['mobile_bind']) && $security_type == MemberAccountSecurity::SECURITY_TYPE_MOBILE) {
                $save_data['status'] = 1;
            } elseif (isset($params['email_bind_token']) && $security_type == MemberAccountSecurity::SECURITY_TYPE_EMAIL) {
                $save_data['flag'] = $params['email_bind_token'];
            }
            MemberAccountSecurity::firstOrCreate([
                'memberId' => $this->id,
                'type' => $security_type
            ], $save_data);
        }
    }
}
