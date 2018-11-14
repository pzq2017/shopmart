<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-form layui-card-header card-header-auto">
                        <form name="staffSearch" onsubmit="return false;">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">登录账号</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="loginName" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">所属角色</label>
                                    <div class="layui-input-block">
                                        <select name="staffRoleId">
                                            <option value="">请选择角色</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <button class="layui-btn" onclick="Search();">
                                        <i class="layui-icon layui-icon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
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
    var params = {};
    var route_url = {
        index: '{{ route('admin.system.staff.index') }}',
        lists: '{{ route('admin.system.staff.lists') }}',
        create: '{{ route('admin.system.staff.create') }}',
        save: '{{ route('admin.system.staff.store') }}',
        edit: '{{ route_uri('admin.system.staff.edit') }}',
        update: '{{ route_uri('admin.system.staff.update') }}',
        delete: '{{ route_uri('admin.system.staff.destroy') }}',
    };
    function Lists() {
        Common.dataTableRender({
            url: route_url.lists,
            param: params,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'loginName', title: '账号', align: 'center'},
                {field: 'staffName', title: '姓名', align: 'center'},
                {field: 'staffPhone', title: '电话', align: 'center'},
                {field: 'staffRoleId', title: '权限', align: 'center', templet: function (d) {
                    if (d.staffRoleId == {{ \App\Models\Staffs::SUPER_USER }}) {
                        return '超管';
                    } else {
                        if (d.role) {
                            return d.role.name;
                        }
                        return '';
                    }
                }},
                {field: 'status', title: '状态',sort: true, align: 'center', templet: function (d) {
                    return (d.status == {{ \App\Models\Staffs::STATUS_ACTIVE }}) ? '已激活' : '未激活';
                }},
                {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
            ]],
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
                    goBack(route_url.index);
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

    layui.use('form', function () {
        layui.form.render();
    })

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