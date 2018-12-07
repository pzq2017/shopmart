<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/27
 * Time: 17:46
 */

namespace App\Services;

use App\Models\Captcha;
use App\Models\Member;
use App\Models\SysConfig;
use Carbon\Carbon;

class MemberService
{
    public static function check_register_limit_words($account)
    {
        $limitWords = SysConfig::getValue('registerLimitWords');
        $words = explode(',', $limitWords);
        $flag = false;
        foreach ($words as $word) {
            if (str_contains($account, $word)) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }

    public static function check_register_account_exist($account)
    {
        if (Member::isExistAccount($account)) {
            return true;
        }
        return false;
    }

    public static function check_register_mobile_exist($mobile)
    {
        if (Member::isExistMobile($mobile)) {
            return true;
        }
        return false;
    }

    public static function check_register_email_exist($email)
    {
        if (Member::isExistEmail($email)) {
            return true;
        }
        return false;
    }

    public static function check_sms_captcha_correct($mobile, $code, $type)
    {
        $captcha = Captcha::check_sms_captcha($mobile, $code, $type);
        if (is_null($captcha)) {
            return 'no_exist';
        } else {
            $current_time = Carbon::now()->getTimestamp();
            $send_time = Carbon::parse($captcha->created_at)->timestamp;
            if (($current_time - $send_time) / 60 > Captcha::TIMEOUT_MINUTE) {
                return 'timeout';
            }
        }
        return '';
    }

    public static function register_validate_rules()
    {
        return [
            'loginAccount'  => ['required', 'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9a-zA-Z]{6,20}$/'],
            'loginPwd'      => ['required', 'regex:/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,20}$/', 'confirmed'],
            'loginPwd_confirmation' => 'required',
            'mobile'        => ['required', 'regex:/^(13|14|15|16|17|18|19)[0-9]{9}$/'],
            'smsCode'       => ['required', 'regex:/^[0-9]{6}$/'],
            'email'         => ['sometimes', 'regex:/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]{2,4}$/'],
            'agreement'     => 'required|accepted'
        ];
    }

    public static function register_validate_message()
    {
        return [
            'loginAccount.required' => '请输入用户名',
            'loginAccount.regex'    => '用户名必须是6-20位字符且是字母和数字组合',
            'loginPwd.required'     => '请输入登录密码',
            'loginPwd.regex'        => '登录密码必须是6-20位字符且至少使用两种字符组合',
            'loginPwd.confirmed'    => '确认密码与登录密码不一致',
            'loginPwd_confirmation.required' => '请输入确认密码',
            'mobile.required'       => '请输入手机号码',
            'mobile.regex'          => '请输入正确的手机号码',
            'smsCode.required'      => '请输入短信验证码',
            'smsCode.regex'         => '短信验证码格式错误',
            'email.regex'           => '请输入正确的电子邮箱',
            'agreement.required'    => '请接受并同意注册协议',
            'agreement.accepted'    => '请接受并同意注册协议',
        ];
    }
}