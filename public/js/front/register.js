var form = document.forms['register'];
var inputClass = {
    inpFocus: 'inp-focus',
    inpBlur: 'inp-blur',
    inpText: '.prompt-text',
    inpError: '.prompt-error',
    inpCorrect: '.prompt-correct'
};
var promptClass = function (obj, tipText, flag) {
    if (flag) {
        obj.removeClass(inputClass.inpBlur).removeClass(inputClass.inpFocus);
        obj.parent().parent().find(inputClass.inpCorrect).show().siblings('li').hide();
    } else {
        obj.addClass(inputClass.inpBlur).removeClass(inputClass.inpFocus);
        obj.parent().parent().find(inputClass.inpError).find('span').html(tipText);
        obj.parent().parent().find(inputClass.inpError).show().siblings('li').hide();
    }
    return flag;
}
var userRegister = {
    func: {
        init: function () {
            $('#loginAccount').val('');
            $('#loginPwd').val('');
            //发送短信验证码
            $('.btn-get-code').click(function () {
                var mobile = $.trim($('#mobile').val()), verifyCode = $.trim($('#verifyCode').val());
                var obj = $(this);
                    obj.removeClass('btn-get-code');
                if (userRegister.func.checkMobile() && userRegister.func.checkVerifyCode()) {
                    $.ajax({
                        url: registerUrl.send_sms,
                        type: 'POST',
                        data: {'mobile' : mobile, 'verifyCode' : verifyCode},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data.code == '0000') {
                                setTime();
                            } else if (data.code == '0001') {
                                promptClass($('#verifyCode'), data.message, false);
                            } else if (data.code == '0002') {
                                promptClass($('#smsCode'), data.message, false);
                            }
                        },
                        error: function () {
                            obj.addClass('btn-get-code');
                            Common.alertErrors('网络超时，请重试');
                        }
                    });
                } else {
                    obj.addClass('btn-get-code');
                }
            })
            //发送验证码倒计时
            var countDown = 60;
            function setTime() {
                if (countDown < 1) {
                    $('.verify-code-btn').removeAttr('disabled');
                    $('.verify-code-btn').html('获取验证码').addClass('btn-get-code').removeClass('disabled');
                } else {
                    $('.verify-code-btn').attr('disabled', 'disabled');
                    $('.verify-code-btn').html(countDown + 's').addClass('disabled')
                    countDown--;
                }
                setTimeout(function () {
                    setTime();
                }, 1000)
            }
        },
        loadRegister: function () {
            $('#loginAccount').blur(function () {
                userRegister.func.checkLoginAccount()
            });
            $('#loginPwd').blur(function () {
                userRegister.func.checkLoginPwd()
            });
            $('#loginPwd_confirmation').blur(function () {
                userRegister.func.checkConfirmPwd()
            });
            $('#mobile').blur(function () {
                userRegister.func.checkMobile()
            });
            $('#verifyCode').blur(function () {
                userRegister.func.checkVerifyCode()
            });
            $('#smsCode').blur(function () {
                userRegister.func.checkSmsCode()
            });
            $('#email').blur(function () {
                userRegister.func.checkEmail()
            });
        },
        checkLoginAccount: function () {
            var inp = $('#loginAccount'), val = $.trim(inp.val()), flag = true;
            if (val == '') {
                flag = promptClass(inp, '请输入用户名', false);
            } else if (/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9a-zA-Z]{6,20}$/.test(val) == false) {
                flag = promptClass(inp, '用户名长度只能在6-20位字符之间且是字母和数字组合', false);
            } else {
                //检验用户名是否已被使用
                $.ajax({
                    url: registerUrl.check_account,
                    type: 'GET',
                    data: {'loginAccount' : val},
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.code != '0000') {
                            flag = promptClass(inp, '该用户名已被使用', false);
                        } else {
                            flag = promptClass(inp, '', true);
                        }
                    }
                });
            }
            return flag;
        },
        checkLoginPwd: function () {
            var inp = $('#loginPwd'), val = inp.val(), flag = true;
            if (/\s/g.test(val)) {
                flag = promptClass(inp, '登陆密码不能包含空格', false);
            } else if (val == '') {
                flag = promptClass(inp, '请输入登录密码', false);
            } else if (/[^\x00-\xff]/ig.test(val)) {
                flag = promptClass(inp, '登录密码不能输入全角字符', false);
            } else if (/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,20}$/.test(val) == false) {
                flag = promptClass(inp, '登录密码必须是6-20位字符且至少使用两种字符组合', false);
            } else {
                flag = promptClass(inp, '', true);
                userRegister.func.judgePwdLevel(val, inputClass.inpCorrect);
            }
            return flag;
        },
        checkConfirmPwd: function () {
            var inp = $('#loginPwd_confirmation'), val = $.trim(inp.val()), flag = true;
            var pwd = $.trim($('#loginPwd').val());
            if (val == '') {
                flag = promptClass(inp, '请输入确认密码', false);
            } else if (pwd != val) {
                flag = promptClass(inp, '确认密码与登录密码不一致', false);
            } else {
                flag = promptClass(inp, '', true);
            }
            return flag;
        },
        checkMobile: function () {
            var inp = $('#mobile'), val = $.trim(inp.val()), flag = true;
            if (val == '') {
                flag = promptClass(inp, '请输入手机号码', false);
            } else if (!/^(13|14|15|16|17|18|19)[0-9]{9}$/.test(val)) {
                flag = promptClass(inp, '请输入正确的手机号码', false);
            }
            //检验手机号是否已被使用
            if (flag) {
                $.ajax({
                    url: registerUrl.check_mobile,
                    type: 'GET',
                    data: {'mobile' : val},
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.code != '0000') {
                            flag = promptClass(inp, '该手机号已存在', false);
                        } else {
                            flag = promptClass(inp, '', true);
                        }
                    }
                });
            }
            return flag;
        },
        checkVerifyCode: function () {
            var inp = $('#verifyCode'), val = $.trim(inp.val()), flag = true;
            if (val == '') {
                flag = promptClass(inp, '请输入验证码', false);
            } else {
                flag = promptClass(inp, '', true);
            }
            return flag;
        },
        checkSmsCode: function () {
            var inp = $('#smsCode'), val = $.trim(inp.val()), flag = true;
            if (val == '') {
                flag = promptClass(inp, '请输入短信验证码', false);
            } else if (!/^[0-9]{6}$/.test(val)) {
                flag = promptClass(inp, '短信验证码格式错误', false);
            } else {
                flag = promptClass(inp, '', true);
            }
            return flag;
        },
        checkEmail: function () {
            var inp = $('#email'), val = $.trim(inp.val()), flag = true;
            if (val == '') {
                inp.removeClass(inputClass.inpBlur).removeClass(inputClass.inpFocus);
                inp.parent().parent().find('.prompt li').hide();
                flag = true;
            } else {
                if(!/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]{2,4}$/.test(email)) {
                    flag = promptClass(inp, '请输入正确的电子邮箱', false);
                }
                //检验电子邮箱是否已被使用
                if (flag) {
                    $.ajax({
                        url: registerUrl.check_email,
                        type: 'GET',
                        data: {'email' : val},
                        async: false,
                        dataType: 'json',
                        success: function (data) {
                            if (data.code != '0000') {
                                flag = promptClass(inp, '该邮箱已存在，请使用其他邮箱', false);
                            } else {
                                flag = promptClass(inp, '', true);
                            }
                        }
                    });
                }
            }
            return flag;
        },
        checkAgreement: function () {
            if ($('.form-agreement').find('label>i').hasClass('checked') ==  false) {
                Common.alertErrors("请接受注册协议");
                return false;
            }
            return true;
        },
        checkRegisterSubmit: function () {
            if (!userRegister.func.checkLoginAccount()) {
                return false;
            }
            if (!userRegister.func.checkLoginPwd()) {
                return false;
            }
            if (!userRegister.func.checkConfirmPwd()) {
                return false;
            }
            if (!userRegister.func.checkMobile()) {
                return false;
            }
            if (!userRegister.func.checkSmsCode()) {
                return false;
            }
            if (!userRegister.func.checkEmail()) {
                return false;
            }
            if (!userRegister.func.checkAgreement()) {
                return false;
            }
        },
        judgePwdLevel: function (password, cls) {
            //判断输入密码的类型
            function CharMode(N) {
                if (N >= 48 && N <= 57) {
                    return 1;
                }
                if (N >= 65 && N <= 90) {
                    return 2;
                }
                if (N >= 97 && N <= 122) {
                    return 4;
                }
                return 8;
            }
            //计算密码模式
            function bitTotal(num) {
                var modes=0;
                for (var i=0; i<4; i++){
                    if (num & 1) {
                        modes++;
                    }
                    num>>>=1;
                }
                return modes;
            }
            //返回强度级别
            function checkStrong(sPW){
                if (sPW.length <= 6) {
                    return 1;
                }
                var Modes = 0;
                for (var i = 0; i < sPW.length; i++){
                    Modes|= CharMode(sPW.charCodeAt(i));
                }
                return bitTotal(Modes);
            }
            //显示颜色
            var oColor = '#CCCCCC';
            var lColor = '#FF0000';
            var mColor = '#FF9900';
            var hColor = '#33CC00';
            var LColor;
            var MColor;
            var HColor;
            if (password === null || password === "") {
                LColor = MColor = HColor = oColor;
            } else {
                var sLevel = checkStrong(password);
                switch (sLevel) {
                    case 0:
                        LColor = MColor = HColor = oColor;
                        break;
                    case 1:
                        LColor = lColor;
                        MColor = HColor = oColor;
                        break;
                    case 2:
                        MColor = mColor;
                        LColor = HColor = oColor;
                        break;
                    default:
                        HColor = hColor;
                        LColor = MColor = oColor;
                }
            }
            $(cls).find("#strength_L").attr("style","background:"+LColor+" none repeat scroll 0% 0%;");
            $(cls).find("#strength_M").attr("style","background:"+MColor+" none repeat scroll 0% 0%;");
            $(cls).find("#strength_H").attr("style","background:"+HColor+" none repeat scroll 0% 0%;");
        }
    }
};

userRegister.func.init();
userRegister.func.loadRegister();

$(function () {
    $('.inp').focus(function () {
        if ($(this).attr('id') != 'email') {
            $(this).addClass(inputClass.inpFocus).removeClass(inputClass.inpBlur);
            if ($(this).val() == '') {
                $(this).parent().parent().find(inputClass.inpText).show().siblings('li').hide();
            }
        }
    });

    $('#loginPwd').keyup(function () {
        $(this).addClass(inputClass.inpFocus).removeClass(inputClass.inpBlur);
        $(this).parent().parent().find(inputClass.inpText).show().siblings('li').hide();
        userRegister.func.judgePwdLevel($(this).val(), inputClass.inpText);
    });

    $('#loginPwd').focus(function () {
        userRegister.func.judgePwdLevel($(this).val(), inputClass.inpText);
    });

    $('.form-agreement').find('label').click(function () {
        var obj = $(this);
        if (obj.find('i').hasClass('checked')) {
            obj.find('i').removeClass('checked');
            obj.parent().find('input').val(0);
        } else {
            obj.find('i').addClass('checked');
            obj.parent().find('input').val(1);
        }
    });

    $('.sub').click(function () {
        if (userRegister.func.checkRegisterSubmit()) {
            $(this).addClass('disabled').removeClass('sub').html('数据提交中...');
            $(this).attr('disabled', 'disabled');

            $.ajax({
                url: registerUrl.register_store,
                type: 'POST',
                data: $('#register').serialize(),
                dataType: 'json',
                contentType : "application/x-www-form-urlencoded; charset=utf-8",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function () {

                },
                success: function (data) {

                }
            });
        }
    });
});
