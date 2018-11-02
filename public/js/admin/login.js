function login() {
    var params = Qk.getParams($('.ipt'));
    Qk.ajaxRequest(window.params.checkLoginUrl, params, 'POST', function (data) {
        if (data.status == 'success') {
            Qk.msg('登录成功', {icon: 1}, function () {
                location.href = '/admin/index';
            })
        } else {
            if (data.info) {
                $('#verifyImg').click();
                Qk.msg(data.info, {icon: 2});
            }
        }
    }, function (errors) {
        if (errors.loginName) {
            Qk.msg(errors.loginName[0], {icon: 2});
        } else if(errors.loginPwd) {
            Qk.msg(errors.loginPwd[0], {icon: 2});
        } else if (errors.verifyCode) {
            $('#verifyImg').click();
            Qk.msg(errors.verifyCode[0], {icon: 2});
        }
    });
}