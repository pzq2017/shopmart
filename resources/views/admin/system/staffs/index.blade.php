<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/javascript">
    var params = {};
    var route_url = {
        index: '{{ route('admin.system.staff.index') }}',
        lists: '{{ route('admin.system.staff.lists') }}',
        create: '{{ route('admin.system.staff.create') }}',
        save: '{{ route('admin.system.staff.store') }}',
        edit: '{{ route_uri('admin.system.staff.edit') }}',
        update: '{{ route_uri('admin.system.staff.update') }}',
        delete: '{{ route_uri('admin.system.staff.destroy') }}',
        get_data: '{{ route_uri('admin.system.staff.get_data') }}',
    };
    function Lists() {
        Common.loadPage(route_url.lists, params, function (page) {
            $('#content_box').html(page);
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {staff: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {staff: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    Lists();
                });
            } else {
                alertErrors(data.info);
            }
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除管理员',
            content: '您确定要删除当前管理员账号吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {staff: id}), null, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Common.close(confirm_dialog);
                        Common.msg("删除成功！", {icon: 1}, function () {
                            Lists();
                        });
                    } else {
                        alertErrors(data.info);
                    }
                });
            }
        })
    }

    function Search() {
        params = {};
        var form = document.forms['staffSearch'];
        if (form.loginName.value)
            params.loginName = form.loginName.value;
        if (form.staffRoleId.value)
            params.staffRoleId = form.staffRoleId.value;
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>