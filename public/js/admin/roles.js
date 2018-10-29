var grid;
$(function () {
    var columns = [
        {display: '权限名称', name: 'name', isSort: false},
        {display: '权限说明', name: 'desc', isSort: false},
        {display: '上次更新日期', name: 'updated_at'},
        {display: '操作', name: '', render: function (rowData, index, value) {
            var h = "";
            h += '<a href="javascript:editRole('+rowData['id']+')">修改</a>';
            h += '&nbsp;&nbsp;<a href="javascript:delRole('+rowData['id']+')">删除</a>';
            return h;
        }}
    ];
    grid = Qk.listGrid(rolesUrl.index, columns);
    grid.reload();
})

function addRole() {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(rolesUrl.create, null, 'GET', function (page) {
        Qk.close(loading);
        $('#pagebody').html(page);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function editRole(id) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(Qk.getRealRoutePath(rolesUrl.edit, {role: id}), null, 'GET', function (page) {
        Qk.close(loading);
        $('#pagebody').html(page);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function saveRole(id) {
    var nodes = zTree.getCheckedNodes(), privileges = [];
    for (var i = 0; i < nodes.length; i++) {
        if (nodes[i].code && privileges.indexOf(nodes[i].code) == -1) {
            privileges.push(nodes[i].code);
        }
    }
    var params = Qk.getParams('.ipt');
        params.privileges = privileges.join(',');
    var saveUrl = id > 0 ? Qk.getRealRoutePath(rolesUrl.update, {role: id}) : rolesUrl.store;
    var loading = Qk.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(saveUrl, params, (id > 0 ? 'PUT' : 'POST'), function (data) {
        Qk.close(loading);
        if (data.status == 'success') {
            Qk.msg('保存成功!', {icon: 1});
            goBack(rolesUrl.index);
        } else {
            Qk.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Qk.close(loading);
        alertErrors(errors);
    });
}

function delRole(id) {
    var confirm_dialog = Qk.confirm({
        title: '删除角色',
        content: '您确定要删除当前角色吗？',
        yes: function () {
            var loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(Qk.getRealRoutePath(rolesUrl.destroy, {role: id}), null, 'DELETE', function (data) {
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