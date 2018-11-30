<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/27
 * Time: 17:46
 */

namespace App\Services;

use App\Models\SysConfig;

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
}