<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-form layui-card-header card-header-auto">
                        <form name="areasSearch" onsubmit="return false;">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">地区名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="name" autocomplete="off" class="layui-input">
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
                        <div>
                            <button class="layui-btn" onclick="Edit(0)">新增</button>
                            <button class="layui-btn" prev="{{ $prev_pid }}" id="back_grade" onclick="backGrade()">返回上一级</button>
                        </div>
                        <table class="layui-hide" id="list-datas" lay-filter="list-datas"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="isShow">
    <input type="checkbox" name="isShow" value="@{{ d.id }}" lay-skin="switch" lay-filter="switchShow" lay-text="显示|隐藏" @{{ d.isShow ? 'checked' : '' }}>
</script>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/javascript">
    var params = {'pid': {{ $pid }}};
    var route_url = {
        index: '{{ route('admin.config.area.index') }}',
        lists: '{{ route('admin.config.area.lists') }}',
        create: '{{ route('admin.config.area.create') }}',
        save: '{{ route('admin.config.area.store') }}',
        edit: '{{ route_uri('admin.config.area.edit') }}',
        update: '{{ route_uri('admin.config.area.update') }}',
        delete: '{{ route_uri('admin.config.area.destroy') }}',
        set_show: '{{ route_uri('admin.config.area.set_show') }}'
    };
    function Lists() {
        Common.dataTableRender({
            url: route_url.lists,
            page: false,
            param: params,
            parseData: function (res) {
                return {
                    "code" : 0,
                    "data" : res.message.lists,
                    "prev_pid" : res.message.prev_pid,
                }
            },
            cols: [[
                {field: 'id', title: 'ID', type: 'numbers', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '地区名称', align: 'center'},
                {field: 'first_letter', title: '名称首字母', align: 'center'},
                {field: 'isShow', title: '是否显示', width: 150, align: 'center', unresize: true, templet: '#isShow'},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'created_at', title: '创建日期',sort: true, width: 180, align: 'center'},
                {title: '操作', width: 200, align: 'center', toolbar: '#actionBar'},
            ]],
            done:function (res) {
                $('#back_grade').attr('prev', res.prev_pid);
            }
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                } else if (event == 'del') {
                    Delete(data.id);
                } else if (event == 'view') {
                    params.pid = data.id;
                    Lists();
                }
            })
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {area: id}) : Common.getRealRoutePath(route_url.create, {pid: params.pid});
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {area: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    goBack(Common.getRealRoutePath(route_url.index, {pid: params.pid}));
                });
            } else {
                Common.alertErrors(data.info);
            }
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除地区',
            content: '您确定要删除当前地区信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {area: id}), null, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Common.close(confirm_dialog);
                        Common.msg("删除成功！", {icon: 1}, function () {
                            Lists();
                        });
                    } else {
                        Common.alertErrors(data.info);
                    }
                });
            }
        })
    }

    layui.use('form', function () {
        layui.form.on('switch(switchShow)', function (obj) {
            var url = Common.getRealRoutePath(route_url.set_show, {area: this.value});
            Common.ajaxRequest(url, {show: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败', {icon: 2});
                }
            });
        });
    })

    function Search() {
        if (params.name) params.name = '';
        var form = document.forms['areasSearch'];
        if (form.name.value)
            params.name = form.name.value;
        Lists();
    }

    function backGrade() {
        params.pid = $('#back_grade').attr('prev');
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>