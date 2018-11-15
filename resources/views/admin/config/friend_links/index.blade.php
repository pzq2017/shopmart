<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-form layui-card-header card-header-auto">
                        <form name="linksSearch" onsubmit="return false;">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">友情链接名称</label>
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
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isShow">
    <input type="checkbox" name="isShow" value="@{{ d.id }}" title="显示" lay-filter="isShow" @{{ d.isShow ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var params = {};
    var route_url = {
        index: '{{ route('admin.config.friend_link.index') }}',
        lists: '{{ route('admin.config.friend_link.lists') }}',
        create: '{{ route('admin.config.friend_link.create') }}',
        save: '{{ route('admin.config.friend_link.store') }}',
        edit: '{{ route_uri('admin.config.friend_link.edit') }}',
        update: '{{ route_uri('admin.config.friend_link.update') }}',
        delete: '{{ route_uri('admin.config.friend_link.destroy') }}',
        show: '{{ route_uri('admin.config.friend_link.is_show') }}',
    };
    function Lists() {
        Common.dataTableRender({
            url: route_url.lists,
            param: params,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '友情链接名称', align: 'center', templet: function (data) {
                    return '<a href="'+data.link+'" target="_blank">'+data.name+'</a>';
                }},
                {field: 'ico', title: '图标', align: 'center', templet: function (data) {
                    return '<img src="/file/'+data.ico+'">';
                }},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'status', title: '是否显示', width: 120, align: 'center', unresize: true, templet: '#isShow'},
                {field: 'created_at', title: '创建日期',sort: true, width: 180, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
            ]],
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {friend_link: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {friend_link: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    goBack(route_url.index);
                });
            } else {
                Common.alertErrors(data.info);
            }
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除友情链接',
            content: '您确定要删除当前友情链接信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {friend_link: id}), null, 'DELETE', function (data) {
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
        layui.form.on('checkbox(isShow)', function (obj) {
            var url = Common.getRealRoutePath(route_url.show, {friend_link: this.value});
            Common.ajaxRequest(url, {isShow: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败');
                }
            });
        });
    })

    function Search() {
        if (params.name) params.name = '';
        var form = document.forms['linksSearch'];
        if (form.name.value)
            params.name = form.name.value;
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>