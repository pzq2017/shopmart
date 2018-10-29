var ztree, grid;
$(function () {
    $('#layout').ligerLayout({
        leftWidth: '230',
        allowLeftCollapse: false,
        allowCenterBottomResize: false
    });
    $('#menuTree').height(Qk.pageHeight() - 36);
    var setting = {
        view: {
            selectedMulti: false,
            dblClickExpand: false
        },
        async: {
            enable: true,
            url: menuUrl.getSysMenusUrl,
            headers: {'X-CSRF-TOKEN': window.params.csrf_token},
            autoParam: ['id', 'name=n', 'level=lv']
        },
        callback: {
            onRightClick: onRightClick,
            onClick: onClick,
            onAsyncSuccess: onAsyncSuccess
        }
    };
    $.fn.zTree.init($('#menuTree'), setting);
    ztree = $.fn.zTree.getZTreeObj('menuTree');
    var columns = [
        {display: '权限名称', name: 'name'},
        {display: '权限代码', name: 'code'},
        {display: '是否菜单权限', name: 'isMenu', render: function (rowData, index, value) {
            return value == 1 ? '是' : '否';
        }},
        {display: '权限资源', name: 'url'},
        {display: '关联资源', name: 'otherUrl'},
        {display: '操作', name: '', render: function (rowData, index, value) {
            var h = "";
            h += '<a href="javascript:editPrivilege('+rowData['id']+')">修改</a>';
            h += '&nbsp;&nbsp;<a href="javascript:delPrivilege('+rowData['id']+')">删除</a>';
            return h;
        }}
    ];
    grid = Qk.listGrid(privilegeUrl.index, columns, {usePager: false, enabledSort: false});
})

function onRightClick(event, treeId, treeNode) {
    if (!treeNode) return;
    var menu;
    $('#' + treeNode.tId).bind('contextmenu', function (e) {
        if (menu) menu.hide();
        var items = [];
        items.push({
            icon: 'add',
            text: '新增菜单',
            click: function (parent, menu) {
                treeNode = ztree.getSelectedNodes()[0];
                addSysMenu({id: 0, parentId: treeNode.id});
            }
        });
        treeNode = ztree.getSelectedNodes()[0];
        if (treeNode.id > 0) {
            items.push({
                icon: 'pencil',
                text: '编辑菜单',
                click: function (parent, menu) {
                    treeNode = ztree.getSelectedNodes()[0];
                    editSysMenu(treeNode.id);
                }
            });
            items.push({
                icon: 'remove',
                text: '删除菜单',
                click: function (parent, menu) {
                    treeNode = ztree.getSelectedNodes()[0];
                    delSysMenu(treeNode);
                }
            })
        }
        menu = $.ligerMenu({top: 100, left: 100, width: 120, items: items});
        menu.show({top: e.pageY, left: e.pageX});
        return false;
    })
}

function onClick(event, treeId, treeNode) {
    if (treeNode.id > 0) {
        $('.toolbar').show();
        $('#maingrid').show();
    } else {
        $('.toolbar').hide();
        $('#maingrid').hide();
    }
    grid.setParm('menuId', treeNode.id);
    grid.reload();
}

function onAsyncSuccess(event, treeId, treeNode, msg) {
    msg = eval('(' + msg + ')');
    if (msg && msg.id == 0) {
        var treeNode = ztree.getNodeByTId('menuTree_1');
            ztree.reAsyncChildNodes(treeNode, "refresh",true);
            ztree.expandAll(treeNode,true);
    }
}

function addSysMenu(params) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(menuUrl.create, params, 'GET', function (html) {
        Qk.close(loading);
        saveSysMenuInfo(0, html);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function editSysMenu(id) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(Qk.getRealRoutePath(menuUrl.edit, {menu: id}), null, 'GET', function (html) {
        Qk.close(loading);
        saveSysMenuInfo(id, html);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function saveSysMenuInfo(id, html) {
    var saveDataUrl = id > 0 ? Qk.getRealRoutePath(menuUrl.update, {menu: id}) : menuUrl.store;
    var dialog = Qk.open({
        title: (id > 0) ? '编辑菜单' : '新增菜单',
        type: 1,
        area: ['320px', '200px'],
        offset: '150px',
        content: html,
        btn: ['确定', '取消'],
        yes: function (index, layero) {
            var post = Qk.getParams('.ipt2');
                post.id = id;
            var loading = Qk.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(saveDataUrl, post, (id > 0 ? 'PUT' : 'POST'), function (data) {
                Qk.close(loading);
                if (data.status == 'success') {
                    Qk.msg('保存成功!', {icon: 1});
                    Qk.close(dialog);
                    treeNode = ztree.getSelectedNodes()[0];
                    ztree.reAsyncChildNodes(treeNode, 'refresh', true);
                } else {
                    Qk.msg('保存失败!', {icon: 2});
                }
            }, function (errors) {
                Qk.close(loading);
                if (errors.name) {
                    Qk.msg(errors.name[0], {icon: 2});
                } else {
                    Qk.msg(errors, {icon: 2});
                }
            });
        }
    })
}

function delSysMenu(treeNode) {
    var confirm_dialog = Qk.confirm({
        title: '删除菜单',
        content: '您确定要删除' + treeNode.name + '菜单项吗？',
        yes: function () {
            var loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(Qk.getRealRoutePath(menuUrl.destroy, {menu: treeNode.id}), null, 'DELETE', function (data) {
                Qk.close(loading);
                if (data.status == 'success') {
                    Qk.msg("删除成功！", {icon: 1});
                    Qk.close(confirm_dialog);
                    ztree.reAsyncChildNodes(treeNode.getParentNode(), 'refresh', true);
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

function addPrivilege() {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    var menuId = ztree.getSelectedNodes()[0].id;
    Qk.ajaxRequest(privilegeUrl.create, {menuId: menuId}, 'GET', function (html) {
        Qk.close(loading);
        savePrivilegeInfo(0, html);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function editPrivilege(id) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(Qk.getRealRoutePath(privilegeUrl.edit, {privilege: id}), null, 'GET', function (html) {
        Qk.close(loading);
        savePrivilegeInfo(id, html);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function savePrivilegeInfo(id, html) {
    var saveDataUrl = id > 0 ? Qk.getRealRoutePath(privilegeUrl.update, {privilege: id}) : privilegeUrl.store;
    var dialog = Qk.open({
        title: id > 0 ? '编辑权限' : '新增权限',
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

function delPrivilege(id) {
    var confirm_dialog = Qk.confirm({
        title: '删除权限',
        content: '您确定要删除当前权限吗？',
        yes: function () {
            var loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(Qk.getRealRoutePath(privilegeUrl.destroy, {privilege: id}), null, 'DELETE', function (data) {
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