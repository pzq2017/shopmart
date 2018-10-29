function login() {
    var loading = Qk.msg('加载中', {icon: 16, time: 60000});
    var params = Qk.getParams($('.ipt'));
    Qk.ajaxRequest(window.params.checkLoginUrl, params, 'POST', function (data) {
        Qk.close(loading);
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
        Qk.close(loading);
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