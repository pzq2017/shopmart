var grid;
$(function () {
    var columns = [
        {display: '职员', name: 'loginName', isSort: false, render: function (rowData, index, value) {
            if (rowData['staff']) {
                return rowData['staff']['loginName'];
            }
        }},
    ];
    if (logType == 2) {
        columns.push(
            {display: '操作功能', name: 'desc', isSort: false},
            {display: '访问路径', name: 'accessUrl', isSort: false},
            {display: '操作IP', name: 'ip', isSort: false},
            {display: '操作时间', name: 'created_at'},
            {display: '传递参数', name: 'op', isSort: false, render: function (rowData, index, value) {
                return '<a href="javascript:view('+rowData['id']+');">查看</a>';
            }}
        );
    } else {
        columns.push(
            {display: '登录时间', name: 'created_at'},
            {display: '登录IP', name: 'loginIp', isSort: false}
        );
    }
    grid = Qk.listGrid(logsUrl.index, columns);
    grid.reload();
    $('#startDate').ligerDateEditor();
    $('#endDate').ligerDateEditor();
})

function searchLogs() {
    var loading = Qk.msg('搜索中，请稍后...', {icon: 16, time: 60000});
    var params = Qk.getParams('.ipsearch');
    grid.removeParm('loginName');
    grid.removeParm('startDate');
    grid.removeParm('endDate');
    if (params.loginName) grid.setParm('loginName', params.loginName);
    if (params.startDate) grid.setParm('startDate', params.startDate);
    if (params.endDate) grid.setParm('endDate', params.endDate);
    grid.reload();
    Qk.close(loading);
}