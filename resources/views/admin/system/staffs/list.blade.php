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
<script>
    Common.dataTableRender({
        url: route_url.get_data,
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
    layui.use('form', function () {
        layui.form.render();
    })
</script>