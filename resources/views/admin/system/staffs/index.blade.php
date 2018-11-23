@section('search')
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
@endsection
@section('handle_button')
    <div><button class="layui-btn" onclick="Edit(0)">新增</button></div>
@endsection
@extends('admin.layout')
<script type="text/html" id="isEnabled">
    <input type="checkbox" name="status" value="@{{ d.id }}" lay-skin="switch" lay-filter="switchStatus" lay-text="激活|禁止" @{{ d.status ? 'checked' : '' }}>
</script>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.system.staff.lists') }}',
        create: '{{ route('admin.system.staff.create') }}',
        save: '{{ route('admin.system.staff.store') }}',
        edit: '{{ route_uri('admin.system.staff.edit') }}',
        update: '{{ route_uri('admin.system.staff.update') }}',
        delete: '{{ route_uri('admin.system.staff.destroy') }}',
        enabled: '{{ route_uri('admin.system.staff.enabled') }}'
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'loginName', title: '账号', align: 'center'},
                {field: 'staffName', title: '姓名', align: 'center'},
                {field: 'staffPhone', title: '电话', align: 'center'},
                {field: 'staffRoleId', title: '权限', align: 'center', templet: function (d) {
                    if (d.staffRoleId == {{ \App\Models\Staffs::SUPER_USER }}) {
                        return '超管';
                    } else {
                        return d.role ? d.role.name : '';
                    }
                }},
                {field: 'status', title: '状态',sort: true, align: 'center', unresize: true, templet: '#isEnabled'},
                {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
            ]],
            done: function (res, curr) {
                curr_page = curr;
            }
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                } else if (event == 'delete') {
                    Delete(data.id);
                }
            });
            $('.card-box').addClass('hidden');
            $('.card-box').eq(0).removeClass('hidden');
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {staff: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {staff: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    Lists(id > 0 ? curr_page : 1);
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
                            Lists(1);
                        });
                    } else {
                        alertErrors(data.info);
                    }
                });
            }
        })
    }

    function Search() {
        search = {};
        var form = document.forms['staffSearch'];
        if (form.loginName.value)
            search.loginName = form.loginName.value;
        if (form.staffRoleId.value)
            search.staffRoleId = form.staffRoleId.value;
        Lists(1);
    }

    layui.use('form', function () {
        layui.form.render();
        layui.form.on('switch(switchStatus)', function (obj) {
            var url = Common.getRealRoutePath(route_url.enabled, {staff: this.value});
            Common.ajaxRequest(url, {enabled: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败', {icon: 2});
                }
            });
        });
    })

    $(document).ready(function () {
        Lists(1);
    });
</script>