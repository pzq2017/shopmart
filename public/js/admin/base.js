function goBack(backurl) {
    Qk.loadPage(backurl, {}, function (page) {
        $('#content_body').html(page);
    })
}

function clearCache() {
    loading = Qk.msg('正在清除缓存，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(window.params.clearCacheUrl, null, 'GET', function (data) {
        if (data.status == 'success') {
            Qk.msg('缓存已成功清除', {icon: 1});
        } else {
            Qk.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Qk.msg('清除缓存操作失败', {icon: 2});
    });
}

function editPwd() {
    var dialog = Qk.open({
        title: '修改密码', 
        type: 1,
        area: ['340px', '230px'],
        offset: '150px',
        content: $('#editPwdBox').html(),
        btn: ['确定', '取消'],
        yes: function (index, layero) {
            var post = Qk.getParams('.ipwd');
            loading = Qk.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(window.params.updPwdUrl, post, 'POST', function (data) {
                if (data.status == 'success') {
                    Qk.msg('修改成功!', {icon: 1});
                    $('#editPwdForm')[0].reset();
                    Qk.close(dialog);
                } else {
                    Qk.msg(data.info, {icon: 2});
                }
            }, function (errors) {
                if (typeof(errors) == 'object') {
                    for (var error in errors) {
                        Qk.msg(errors[error][0], {icon: 2});
                        return;
                    }
                } else {
                    Qk.msg(errors, {icon: 2});
                }
            });
        }
    })
}

function logout() {
    loading = Qk.msg('正在退出账号，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(window.params.logoutUrl, null, 'GET', function (data) {
        if (data.status == 'success') {
            Qk.msg('账号已成功退出', {icon: 1}, function () {
                location.href = '/admin/login';
            })
        } else {
            Qk.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Qk.msg('账号退出异常', {icon: 2});
    });
}

function alertErrors(errors) {
    if (typeof(errors) == 'object') {
        for (var error in errors) {
            Qk.msg(errors[error][0], {icon: 2});
            return;
        }
    } else {
        Qk.msg(errors, {icon: 2});
    }
}

function uploadFile(objId, picId, acceptType, acceptExts, psize, handleType) {
    layui.use('upload', function () {
        var load;
        layui.upload.render({
            elem: '#' + objId,
            url: baseParams.upload_url,
            headers: {'X-CSRF-TOKEN': baseParams.csrf_token},
            size: Qk.maxUploadSize,     //KB
            accept: acceptType,         //images, file, video, audio
            exts: acceptExts,
            data: {psize: psize, handleType: handleType},
            before: function(obj){
                load = Qk.loading();
            },
            done: function(res){
                Qk.close(load);
                if (res.status == 'success') {
                    $('#' + picId + '_preview').attr('src', '/file/temp/' + res.message);
                    $('#' + picId + '_value').val(res.message);
                } else {
                    if (res.info) {
                        Qk.msg(res.info, {icon: 2});
                    } else {
                        Qk.msg('上传失败.', {icon: 2});
                    }
                }
            },
            error: function(){
                Qk.close(load);
                Qk.msg('上传失败.', {icon: 2});
            }
        });
    })
}