<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    protected $table = 'captcha';

    protected $fillable = ['mobile', 'code', 'ip', 'type'];

    protected $dates = ['created_at', 'updated_at'];

    const TIMEOUT_MINUTE = 30;

    const TYPE_REGISTER = 1;

    public static function makeRandCode($length)
    {
        $str = '0123456789';
        $sLen = strlen($str) - 1;
        $code = '';
        while ($length--) {
            $pos = mt_rand(0, $sLen);
            $code .= $str[$pos];
        }
        return $code;
    }

    public static function check_sms_captcha($mobile, $code, $type)
    {
        return self::where([
            ['mobile', '=', $mobile],
            ['code', '=', $code],
            ['type', '=', $type],
            ['status', '=', 0]
        ])->latest()->first();
    }

    public function setCaptchaUsed($mobile, $code, $type)
    {
        self::where([
            ['mobile', '=', $mobile],
            ['code', '=', $code],
            ['type', '=', $type],
            ['status', '=', 0]
        ])->update(['status' => 1]);
    }
}
