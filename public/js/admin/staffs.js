var grid;
$(function () {
    var columns = [
        {display: '编号', name: 'staffNo'},
        {display: '职员账号', name: 'loginName', isSort: false, render: function (rowData, index, value) {
            return value + (rowData['staffStatus'] == 0 ? '<span class="account_disable">停用</span>' : '');
        }},
        {display: '职员姓名', name: 'staffName', isSort: false},
        {display: '职员角色', name: 'staffRoleId', isSort: false, render: function (rowData, index, value) {
            if (value == -1) {
                return '超管';
            } else if (value > 0) {
                return rowData['role']['name'];
            } else {
                return '-';
            }
        }},
        {display: '工作状态', name: 'workStatus', isSort: false, render: function (rowData, index, value) {
            return value == 1 ? '在职' : '离职';
        }},
        {display: '上次修改日期', name: 'updated_at'},
        {display: '操作', name: '', render: function (rowData, index, value) {
            var h = "";
            h += '&nbsp;&nbsp;<a href="javascript:editStaff('+rowData['id']+')">修改</a>';
            if (rowData['staffRoleId'] != -1) {
                h += '&nbsp;&nbsp;<a href="javascript:delStaff('+rowData['id']+')">删除</a>';
            }
            return h;
        }}
    ];
    grid = Qk.listGrid(staffsUrl.index, columns);
    grid.reload();
})

function addStaff() {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(staffsUrl.create, null, 'GET', function (page) {
        Qk.close(loading);
        $('#pagebody').html(page);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function editStaff(id) {
    var loading = Qk.msg('正在加载数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(Qk.getRealRoutePath(staffsUrl.edit, {staff: id}), null, 'GET', function (page) {
        Qk.close(loading);
        $('#pagebody').html(page);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg(errors, {icon: 2});
    }, 'html');
}

function saveStaff(id) {
    var params = Qk.getParams('.ipt');
    var saveUrl = id > 0 ? Qk.getRealRoutePath(staffsUrl.update, {staff: id}) : staffsUrl.store;
    var loading = Qk.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(saveUrl, params, (id > 0 ? 'PUT' : 'POST'), function (data) {
        Qk.close(loading);
        if (data.status == 'success') {
            Qk.msg('保存成功!', {icon: 1});
            goBack(staffsUrl.index);
        } else {
            Qk.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Qk.close(loading);
        alertErrors(errors);
    });
}

function delStaff(id) {
    var confirm_dialog = Qk.confirm({
        title: '删除职员',
        content: '您确定要删除当前职员吗？',
        yes: function () {
            var loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(Qk.getRealRoutePath(staffsUrl.destroy, {staff: id}), null, 'DELETE', function (data) {
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

function searchStaff() {
    var dialog = Qk.open({
        title: '职员搜索',
        type: 1,
        area: ['320px', '260px'],
        offset: '100px',
        content: $('#searchBox').html(),
        btn: ['确定', '取消'],
        yes: function (index, layero) {
            var loading = Qk.msg('搜索中，请稍后...', {icon: 16, time: 60000});
            var params = Qk.getParams('.ipsearch');
            grid.removeParm('loginName');
            grid.removeParm('staffName');
            grid.removeParm('staffRoleId');
            grid.removeParm('workStatus');
            if (params.loginName) grid.setParm('loginName', params.loginName);
            if (params.staffName) grid.setParm('staffName', params.staffName);
            if (params.staffRoleId) grid.setParm('staffRoleId', params.staffRoleId);
            if (params.workStatus) grid.setParm('workStatus', params.workStatus);
            grid.reload();
            Qk.close(dialog);
            Qk.close(loading);
        }
    }); 
}