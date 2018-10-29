var grid;
$(function () {
    grid = $('#maingrid').GridTree({
        url: homemenuUrl.index,
        rowNumbers: true,
        columns: [
            {display: '菜单名称', name: 'name', id: 'id'},
            {display: '菜单类型', name: 'type', render: function (rowData) {
                return  rowData['typeName'];
            }},
            {display: '菜单url', name: 'url'},
            {display: '是否显示', name: 'isShow', render: function (rowData) {
                return rowData['isShow'] == 1 ? '显示' : '不显示';
            }},
            {display: '排序号', name: 'sort'},
            {display: '操作', name: '', render: function (rowData) {
                var h = "";
                h += '<a href="javascript:addHomeMenu('+rowData['id']+')">添加子菜单</a>';
                h += '&nbsp;&nbsp;<a href="javascript:editHomeMenu('+rowData['id']+')">修改</a>';
                h += '&nbsp;&nbsp;<a href="javascript:delHomeMenu('+rowData['id']+')">删除</a>';
                return h;
            }}
        ]
    });
    $('#s_menuType').change(function () {
        var selval = $(this).val();
        grid.reload({type: selval});
    });
})

function addHomeMenu(pid) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(homemenuUrl.create, {parentId: pid}, 'GET', function (html) {
        Qk.close(loading);
        saveHomeMenuInfo(0, html);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function editHomeMenu(id) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(Qk.getRealRoutePath(homemenuUrl.edit, {homemenu: id}), null, 'GET', function (html) {
        Qk.close(loading);
        saveHomeMenuInfo(id, html);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function saveHomeMenuInfo(id, html) {
    var saveDataUrl = id > 0 ? Qk.getRealRoutePath(homemenuUrl.update, {homemenu: id}) : homemenuUrl.store;
    var dialog = Qk.open({
        title: id > 0 ? '编辑前台菜单' : '新增前台菜单',
        type: 1,
        area: ['500px', '340px'],
        offset: '100px',
        content: html,
        btn: ['确定', '取消'],
        yes: function (index, layero) {
            var post = Qk.getParams('.ipt');
                post.id = id;
            var loading = Qk.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(saveDataUrl, post, (id > 0 ? 'PUT' : 'POST'), function (data) {
                Qk.close(loading);
                if (data.status == 'success') {
                    Qk.msg('保存成功!', {icon: 1});
                    Qk.close(dialog);
                    grid.reload();
                } else {
                    Qk.msg(data.info, {icon: 2});
                }
            }, function (errors) {
                Qk.close(loading);
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
    });
}

function delHomeMenu(id) {
    var confirm_dialog = Qk.confirm({
        title: '删除前台菜单',
        content: '您确定要删除当前菜单吗？',
        yes: function () {
            var loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(Qk.getRealRoutePath(homemenuUrl.destroy, {homemenu: id}), null, 'DELETE', function (data) {
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