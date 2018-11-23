@section('search')
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
@endsection
@section('handle_button')
    <div><button class="layui-btn" onclick="Edit(0)">新增</button></div>
@endsection
@extends('admin.layout')
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isShow">
    <input type="checkbox" name="isShow" value="@{{ d.id }}" title="显示" lay-filter="isShow" @{{ d.isShow ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.config.friend_link.lists') }}',
        create: '{{ route('admin.config.friend_link.create') }}',
        save: '{{ route('admin.config.friend_link.store') }}',
        edit: '{{ route_uri('admin.config.friend_link.edit') }}',
        update: '{{ route_uri('admin.config.friend_link.update') }}',
        delete: '{{ route_uri('admin.config.friend_link.destroy') }}',
        show: '{{ route_uri('admin.config.friend_link.is_show') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
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
        var url = id ? Common.getRealRoutePath(route_url.edit, {friend_link: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {friend_link: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    Lists(id > 0 ? curr_page : 1);
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
                            Lists(1);
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
        search = {};
        var form = document.forms['linksSearch'];
        if (form.name.value)
            search.name = form.name.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>