var grid, editor;
$(function () {
    var columns = [
        {display: '消息类型', name: 'type', render: function (rowData) {
            return rowData['typeName'];
        }},
        {display: '发送者', name: 'sendUserId', render: function (rowData) {
            if (rowData['sendUserId'] > 0) {
                return rowData['staffName'];
            }
            return '';
        }},
        {display: '发送状态', name: 'status', render: function (rowData, index, value) {
            return value == 1 ? '已发送' : '未发送';
        }},
        {display: '创建时间', name: 'created_at'},
        {display: '操作', name: '', render: function (rowData) {
            var h = "";
            h += '&nbsp;&nbsp;<a href="javascript:editMessages('+rowData['id']+')">编辑</a>';
            h += '&nbsp;&nbsp;<a href="javascript:viewMessages('+rowData['id']+')">查看</a>';
            h += '&nbsp;&nbsp;<a href="javascript:delMessages('+rowData['id']+')">删除</a>';
            return h;
        }}
    ];
    grid = Qk.listGrid(messagesUrl.index, columns);
    grid.reload();
})

function addMessages() {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(messagesUrl.create, null, 'GET', function (page) {
        Qk.close(loading);
        $('#pagebody').html(page);
        editor = KindEditor.create('textarea[name="message"]', {width: '90%', height: '400px', filterMode: false});
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function editMessages(id) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(Qk.getRealRoutePath(messagesUrl.edit, {message: id}), null, 'GET', function (page) {
        Qk.close(loading);
        $('#pagebody').html(page);
        editor = KindEditor.create('textarea[name="message"]', {width: '90%', height: '400px', filterMode: false});
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function saveMessages(id) {
    var params = Qk.getParams('.ipt');
        params.message = editor.html();
    var saveUrl = id > 0 ? Qk.getRealRoutePath(messagesUrl.update, {message: id}) : messagesUrl.store;
    var loading = Qk.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(saveUrl, params, (id > 0 ? 'PUT' : 'POST'), function (data) {
        Qk.close(loading);
        if (data.status == 'success') {
            Qk.msg('保存成功!', {icon: 1});
            if (data.message.id > 0) {
                location.href = Qk.getRealRoutePath(messagesUrl.sendSet, {message: data.message.id});
            } else {
                goBack(messagesUrl.index);
            }
        } else {
            Qk.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Qk.close(loading);
        alertErrors(errors);
    });
}

function delMessages(id) {
    var confirm_dialog = Qk.confirm({
        title: '删除职员',
        content: '您确定要删除当前职员吗？',
        yes: function () {
            var loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(Qk.getRealRoutePath(messagesUrl.destroy, {message: id}), null, 'DELETE', function (data) {
                Qk.close(loading);
                if (data.status == 'success') {
                    Qk.msg("删除成功！", {icon: 1});
                    Qk.close(confirm_dialog);
                    grid.reload();
                } else {
                    Qk.msg(data.info, {icon: 2});
                }
            }, function (errors) {
                Qk.close(loading);
                Qk.msg(errors, {icon: 2});
            });
        }
    })
}