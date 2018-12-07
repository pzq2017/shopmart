<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Captcha;
use App\Models\Member;
use App\Models\MemberAccountSecurity;
use App\Notifications\EmailActivateEmail;
use App\Services\MemberService;
use App\Traits\ResponseJsonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class RegisterController extends Controller
{
    use ResponseJsonTrait;

    public function index()
    {
        return view('front.auth.register');
    }

    public function checkAccount(Request $request)
    {
        if (MemberService::check_register_account_exist($request->get('loginAccount'))) {
            $code = '0001';
        } elseif (MemberService::check_register_limit_words($request->get('loginAccount'))) {
            $code = '0002';
        } else {
            $code = '0000';
        }
        return $this->handleResult($code);
    }

    public function checkMobile(Request $request)
    {
        $mobile = trim($request->get('mobile'));
        if (MemberService::check_register_mobile_exist($mobile)) {
            $code = '0001';
        } else {
            $code = '0000';
        }
        return $this->handleResult($code);
    }

    public function checkEmail(Request $request)
    {
        $email = trim($request->get('email'));
        if (MemberService::check_register_email_exist($email)) {
            $code = '0001';
        } else {
            $code = '0000';
        }
        return $this->handleResult($code);
    }

    public function sendSms(Request $request)
    {
        $mobile = trim($request->get('mobile'));
        $verifyCode = trim($request->get('verifyCode'));
        if (captcha_check($verifyCode) == false) {
            return $this->handleResult('0001', '验证码错误，请正确输入');
        } else {
            $code = Captcha::makeRandCode(6);
            if (empty($code)) {
                return $this->handleResult('0002', '短信验证码获取失败');
            } else {
                $captcha = Captcha::create([
                    'mobile'=> $mobile,
                    'code'  => $code,
                    'ip'    => $request->getClientIp(),
                    'type'  => Captcha::TYPE_REGISTER
                ]);
                if ($captcha && $captcha->id > 0) {
                    //调用短信提供商的API接口实现短信发送
                    return $this->handleResult('0000');
                }
                return $this->handleResult('0002', '短信验证码获取失败');
            }
        }
    }

    public function store(Request $request)
    {
        $validator = $this->validate_request($request);
        if ($validator->fails()) {
            return $this->handleResult('0002', $validator->errors()->getMessages());
        } else {
            DB::beginTransaction();
            try {
                $securities = ['password_level' => $request->password_level, 'mobile_bind' => 1];
                //标记短信验证码已使用
                $captcha = new Captcha();
                $captcha->setCaptchaUsed($request->mobile, $request->smsCode, Captcha::TYPE_REGISTER);
                //创建新用户
                $member = Member::create([
                    'loginAccount'  => $request->loginAccount,
                    'loginPwd'      => \Hash::make($request->loginPwd),
                    'mobile'        => $request->mobile,
                    'email'         => $request->email ?? '',
                    'status'        => 1
                ]);
                dd($member);
                //发送邮箱激活邮件
                if (!empty($request->email)) {
                    $token = \Hash::make($member->loginAccount.Carbon::now()->getTimestamp());
                    Notification::send($member, new EmailActivateEmail($member, $token));
                    $securities['email_bind_token'] = $token;
                }
                //存储用户安全等级信息
                $member->createAccountSecurity($securities);
                //把用户基本信息存放在session里
                \Session::put('member', [
                    'id' => $member->id,
                    'account' => $member->loginAccount,
                ]);
                DB::commit();
                return $this->handleResult('0000');
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
                DB::rollBack();
                return $this->handleResult('0001');
            }
        }
    }

    private function validate_request($request)
    {
        $validator = \Validator::make($request->all(), MemberService::register_validate_rules(), MemberService::register_validate_message());
        $validator->after(function ($validator) use ($request) {
            $this->withValidator($validator, $request);
        });
        return $validator;
    }

    private function withValidator($validator, $request)
    {
        if (!empty($request->loginAccount)) {
            if (MemberService::check_register_limit_words($request->loginAccount)) {
                $validator->errors()->add('loginAccount', '用户名含有非法字符');
            } elseif (MemberService::check_register_account_exist($request->loginAccount)) {
                $validator->errors()->add('loginAccount', '该用户名已被使用');
            }
        }
        if (!empty($request->mobile)) {
            if (MemberService::check_register_mobile_exist($request->mobile)) {
                $validator->errors()->add('mobile', '该手机号已存在');
            }
            if (!empty($request->smsCode)) {
                $res = MemberService::check_sms_captcha_correct($request->mobile, $request->smsCode, Captcha::TYPE_REGISTER);
                if ($res == 'no_exist') {
                    $validator->errors()->add('smsCode', '短信验证码不正确');
                } elseif ($res == 'timeout') {
                    $validator->errors()->add('smsCode', '该短信验证码已超时,请重新发送');
                }
            }
        }
        if (!empty($request->email)) {
            if (MemberService::check_register_email_exist($request->email)) {
                $validator->errors()->add('email', '该邮箱已存在，请使用其它邮箱');
            }
        }
    }
}
