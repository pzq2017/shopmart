function goBack(backurl) {
    Common.loadPage(backurl, {}, function (page) {
        $('#content_body').html(page);
    })
}

function clearCache() {
    loading = Common.msg('正在清除缓存，请稍后...', {icon: 16, time: 60000});
    Common.ajaxRequest(window.params.clearCacheUrl, null, 'GET', function (data) {
        if (data.status == 'success') {
            Common.msg('缓存已成功清除', {icon: 1});
        } else {
            Common.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Common.msg('清除缓存操作失败', {icon: 2});
    });
}

function editPwd() {
    var dialog = Common.open({
        title: '修改密码', 
        type: 1,
        area: ['340px', '230px'],
        offset: '150px',
        content: $('#editPwdBox').html(),
        btn: ['确定', '取消'],
        yes: function (index, layero) {
            var post = Common.getParams('.ipwd');
            loading = Common.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
            Common.ajaxRequest(window.params.updPwdUrl, post, 'POST', function (data) {
                if (data.status == 'success') {
                    Common.msg('修改成功!', {icon: 1});
                    $('#editPwdForm')[0].reset();
                    Common.close(dialog);
                } else {
                    Common.msg(data.info, {icon: 2});
                }
            }, function (errors) {
                if (typeof(errors) == 'object') {
                    for (var error in errors) {
                        Common.msg(errors[error][0], {icon: 2});
                        return;
                    }
                } else {
                    Common.msg(errors, {icon: 2});
                }
            });
        }
    })
}

function logout() {
    loading = Common.msg('正在退出账号，请稍后...', {icon: 16, time: 60000});
    Common.ajaxRequest(window.params.logoutUrl, null, 'GET', function (data) {
        if (data.status == 'success') {
            Common.msg('账号已成功退出', {icon: 1}, function () {
                location.href = '/admin/login';
            })
        } else {
            Common.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Common.msg('账号退出异常', {icon: 2});
    });
}

function uploadFile(objId, acceptType, acceptExts, pSize, handleType) {
    if (!pSize) pSize = '';
    if (!handleType) handleType = '';
    layui.use('upload', function () {
        var load;
        layui.upload.render({
            elem: '#' + objId + '_upload',
            url: baseParams.upload_url,
            headers: {'X-CSRF-TOKEN': baseParams.csrf_token},
            size: Const.maxUploadSize,     //KB
            accept: acceptType,         //images, file, video, audio
            exts: acceptExts,
            data: {type: acceptType, pSize: pSize, handleType: handleType},
            before: function(obj){
                load = Common.loading();
            },
            done: function(res){
                Common.close(load);
                if (res.status == 'success') {
                    if (acceptType == 'images') {
                        $('#' + objId + '_preview').attr('src', '/file/temp/' + res.message);
                        $('#' + objId + '_preview').parent().removeClass('hidden');
                    }
                    $('#' + objId + '_value').val(res.message);
                } else {
                    if (res.info) {
                        Common.alertErrors(res.info);
                    } else {
                        Common.alertErrors('上传失败.');
                    }
                }
            },
            error: function(){
                Common.close(load);
                Common.alertErrors('上传失败.');
            }
        });
    })
}