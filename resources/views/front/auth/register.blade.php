<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="stylesheet" type="text/css" href="plugin/layui/css/layui.css"/>
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/auth.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type='text/javascript' src='plugin/layui/layui.js'></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript">
        var registerUrl = {
            check_account: '{{ route('register.check_account') }}',
            check_mobile: '{{ route('register.check_mobile') }}',
            check_email: '{{ route('register.check_email') }}',
            send_sms: '{{ route('register.send_sms') }}',
            register_store: '{{ route('register.store') }}',
            agreement: '{{ route('agreement.register') }}'
        };
    </script>
</head>
<body class="w960 register_body">
    <div class="header">
        <div class="wrap">
            <div class="logo">
                <div class="fl"></div>
                <div class="fl"></div>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="main">
            <div class="main-center">
                <div class="center-top">
                    <div class="title-info">Hi～欢迎来注册</div>
                    <div class="title-login">如有账号，请点击 <a href="#">登录</a></div>
                </div>
                <div class="center-bottom">
                    <form id="register" onsubmit="return false;">
                    <div class="register-form">
                        <div class="form-item">
                            <div class="form-item-name"><i>* </i>用户名：</div>
                            <div class="form-item-input"><input type="text" id="loginAccount" name="loginAccount" autocomplete="off" class="inp" placeholder="6-20位字符，字母与数字组合"></div>
                            <ul class="prompt">
                                <li class="prompt-text"><i></i><span>请输入用户名</span></li>
                                <li class="prompt-error"><i></i><span>用户名只能由字母或字母和数字组合</span></li>
                                <li class="prompt-correct"><i></i><span></span></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-item">
                            <div class="form-item-name"><i>* </i>登录密码：</div>
                            <div class="form-item-input"><input type="password" id="loginPwd" name="loginPwd" class="inp" placeholder="6-20位字符，至少使用两种字符组合"></div>
                            <ul class="prompt">
                                <li class="prompt-text">
                                    <i></i><span>密码强度</span>
                                    <i id="strength_L" class="pwd-strength" style="margin-left: 10px;">弱</i>
                                    <i id="strength_M" class="pwd-strength">中</i>
                                    <i id="strength_H" class="pwd-strength">强</i>
                                </li>
                                <li class="prompt-error"><i></i><span>请输入登陆密码</span></li>
                                <li class="prompt-correct">
                                    <i></i><span>密码强度</span>
                                    <i id="strength_L" class="pwd-strength" style="margin-left: 10px;">弱</i>
                                    <i id="strength_M" class="pwd-strength">中</i>
                                    <i id="strength_H" class="pwd-strength">强</i>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-item">
                            <div class="form-item-name"><i>* </i>确认密码：</div>
                            <div class="form-item-input"><input type="password" id="loginPwd_confirmation" name="loginPwd_confirmation" class="inp" placeholder="请再次输入密码"></div>
                            <ul class="prompt">
                                <li class="prompt-text"><i></i><span>请输入确认密码</span></li>
                                <li class="prompt-error"><i></i><span>请输入确认密码</span></li>
                                <li class="prompt-correct"><i></i><span></span></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-item">
                            <div class="form-item-name"><i>* </i>手机号：</div>
                            <div class="form-item-input"><input type="text" id="mobile" name="mobile" class="inp" autocomplete="off" placeholder="请输入11位手机号码"></div>
                            <ul class="prompt">
                                <li class="prompt-text"><i></i><span>请输入手机号码</span></li>
                                <li class="prompt-error"><i></i><span>请输入手机号码</span></li>
                                <li class="prompt-correct"><i></i><span></span></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-item">
                            <div class="form-item-name">验证码：</div>
                            <div class="form-item-input"><input type="text" id="verifyCode" name="verifyCode" class="inp" style="width: 130px;" autocomplete="off" placeholder="请输入验证码"></div>
                            <div class="form-item-input"><img id='verifyImg' class="verify-code" src="{{ captcha_src() }}" title="看不清?点击换一张" onclick="this.src='{{ captcha_src() }}?'+Math.random()"></div>
                            <ul class="prompt">
                                <li class="prompt-text"><i></i><span>请输入验证码</span></li>
                                <li class="prompt-error"><i></i><span></span></li>
                                <li class="prompt-correct"><i></i><span></span></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-item">
                            <div class="form-item-name"><i>* </i>短信验证码：</div>
                            <div class="form-item-input"><input type="text" id="smsCode" name="smsCode" class="inp" style="width: 130px;" autocomplete="off" placeholder="请输入短信验证码"></div>
                            <div class="form-item-input"><button class="btn verify-code-btn btn-get-code">获取验证码</button></div>
                            <ul class="prompt">
                                <li class="prompt-text"><i></i><span>请输入短信验证码</span></li>
                                <li class="prompt-error"><i></i><span>请输入短信验证码</span></li>
                                <li class="prompt-correct"><i></i><span></span></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-item">
                            <div class="form-item-name">电子邮箱：</div>
                            <div class="form-item-input"><input type="text" id="email" name="email" class="inp" autocomplete="off" placeholder="请输入有效邮箱"></div>
                            <ul class="prompt">
                                <li class="prompt-text"><i></i><span>请输入电子邮箱</span></li>
                                <li class="prompt-error"><i></i><span>用户名只能由字母或字母和数字组合</span></li>
                                <li class="prompt-correct"><i></i><span></span></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-agreement">
                            <label><i></i><span>我已阅读并同意</span></label>
                            <a id="register_agreement" href="javascript:void(0);">《注册协议》</a>
                            <input type="hidden" name="agreement">
                        </div>
                        <div class="form-button">
                            <button type="button" class="btn btn-register sub">立即注册</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/front/register.js"></script>
</body>
</html>