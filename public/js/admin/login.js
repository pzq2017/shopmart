function login() {
    var params = Common.getParams($('.ipt'));
    Common.ajaxRequest(baseParams.checkLoginUrl, params, 'POST', function (data) {
        if (data.status == 'success') {
            Common.msg('登录成功', {icon: 1}, function () {
                location.href = '/admin/index';
            })
        } else {
            if (data.info) {
                $('#verifyImg').click();
                Common.msg(data.info, {icon: 2});
            }
        }
    }, function (errors) {
        alertErrors(errors);
    });
}