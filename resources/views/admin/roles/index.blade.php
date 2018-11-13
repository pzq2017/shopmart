<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-card-body">
                        <div><button class="layui-btn" onclick="Edit(0)">新增</button></div>
                        <table class="layui-hide" id="list-datas" lay-filter="list-datas"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/javascript">
    var params = {'_token': baseParams.csrf_token};
    function Lists() {
        layui.use('table', function () {
            var table = layui.table;
            table.render({
                elem: '#list-datas',
                url: '{{ route('admin.system.role.lists') }}',
                where: params,
                page: true,
                limit: Const.defaultPageSize,
                limits: Const.defaultPageSizeOptions,
                parseData: function (res) {
                    return {
                        "code" : 0,
                        "data" : res.message.lists,
                        "count": res.message.total,
                    }
                },
                cols: [[
                    {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                    {field: 'name', title: '权限名称', align: 'center'},
                    {field: 'desc', title: '权限说明', align: 'center'},
                    {field: 'updated_at', title: '上次更新日期', sort: true, width: 200, align: 'center'},
                    {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
                ]],
                text: {
                    none: '暂无数据...'
                },
            });

            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                } else if (event == 'del') {
                    Delete(data.id);
                }
            })
        })
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath('{{ route_uri('admin.system.role.edit') }}', {'role': id}) : '{{ route('admin.system.role.create') }}';
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var nodes = zTree.getCheckedNodes(), privileges = [];
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].id && privileges.indexOf(nodes[i].id) == -1) {
                privileges.push(nodes[i].id);
            }
        }
        form_datas.privileges = privileges.join(',');

        var saveUrl = id > 0 ? Common.getRealRoutePath('{{ route_uri('admin.system.role.update') }}', {role: id}) : '{{ route('admin.system.role.store') }}';
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    goBack('{{ route('admin.system.role.index') }}');
                });
            } else {
                Common.msg(data.info, {icon: 2});
            }
        }, function (errors) {
            alertErrors(errors);
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除角色',
            content: '您确定要删除当前角色吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath('{{ route_uri('admin.system.role.destroy') }}', {role: id}), null, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Common.close(confirm_dialog);
                        Common.msg("删除成功！", {icon: 1}, function () {
                            Lists();
                        });
                    } else {
                        Common.msg(data.info, {icon: 2});
                    }
                }, function (errors) {
                    Common.msg(errors, {icon: 2});
                });
            }
        })
    }

    $(document).ready(function () {
        Lists();
    });
</script>