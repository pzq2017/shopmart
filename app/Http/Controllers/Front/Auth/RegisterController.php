<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Captcha;
use App\Models\Member;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('front.auth.register');
    }

    public function checkAccount(Request $request)
    {
        $loginAccount = trim($request->get('loginAccount'));
        if (Member::isExistAccount($loginAccount)) {
            return response()->json([
                'code' => '0001'
            ]);
        } else {
            return response()->json([
                'code' => '0000'
            ]);
        }
    }

    public function checkMobile(Request $request)
    {
        $mobile = trim($request->get('mobile'));
        if (Member::isExistMobile($mobile)) {
            return response()->json([
                'code' => '0001'
            ]);
        } else {
            return response()->json([
                'code' => '0000'
            ]);
        }
    }

    public function checkEmail(Request $request)
    {
        $email = trim($request->get('email'));
        if (Member::isExistEmail($email)) {
            return response()->json([
                'code' => '0001'
            ]);
        } else {
            return response()->json([
                'code' => '0000'
            ]);
        }
    }

    public function sendSms(Request $request)
    {
        $mobile = trim($request->get('mobile'));
        $verifyCode = trim($request->get('verifyCode'));
        if (captcha_check($verifyCode) == false) {
            return response()->json([
                'code'    => '0001',
                'message' => '验证码错误，请正确输入'
            ]);
        } else {
            $code = Captcha::makeRandCode(6);
            if (empty($code)) {
                return response()->json([
                    'code'    => '0002',
                    'message' => '短信验证码获取失败'
                ]);
            } else {
                $captcha = Captcha::create([
                    'mobile'=> $mobile,
                    'code'  => $code,
                    'ip'    => $request->getClientIp(),
                    'type'  => Captcha::TYPE_REGISTER
                ]);
                if ($captcha && $captcha->id > 0) {
                    //调用短信提供商的API接口实现短信发送
                    return response()->json([
                        'code' => '0000'
                    ]);
                }
                return response()->json([
                    'code'    => '0002',
                    'message' => '短信验证码获取失败'
                ]);
            }
        }
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), null, [

        ]);
    }

    private function getRules()
    {
        $rules['loginAccount'] = ['required', 'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9a-zA-Z]{6,20}$/'];
        $rules['loginPwd'] = ['required', 'regex:/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,20}$/'];
        $rules['playlist'] = 'required';
        $rules['img_method'] = 'required';
        $rules['is_scheduled'] = 'required|in:0,1';
    }
}
