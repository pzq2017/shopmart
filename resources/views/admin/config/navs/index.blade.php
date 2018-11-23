@section('search')
    <div class="layui-form layui-card-header card-header-auto">
        <form name="navsSearch" onsubmit="return false;">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">导航名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">导航类型</label>
                    <div class="layui-input-block">
                        <select name="type">
                            <option value="">请选择类型</option>
                            @foreach(\App\Models\Navs::NAVS_POSITIONS as $index => $pos)
                                <option value="{{ ++$index }}">{{ $pos }}</option>
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
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
</script>
<script type="text/html" id="isShow">
    <input type="checkbox" name="isShow" value="@{{ d.id }}" lay-skin="switch" lay-filter="switchShow" lay-text="显示|隐藏" @{{ d.isShow ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.config.nav.lists') }}',
        create: '{{ route('admin.config.nav.create') }}',
        save: '{{ route('admin.config.nav.store') }}',
        edit: '{{ route_uri('admin.config.nav.edit') }}',
        update: '{{ route_uri('admin.config.nav.update') }}',
        set_show: '{{ route_uri('admin.config.nav.set_show') }}'
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'type', title: '类型', sort: true, width: 150, align: 'center', templet: function (data) {
                    return data.typeName;
                }},
                {field: 'name', title: '名称', width: 200, align: 'center'},
                {field: 'url', title: '链接', align: 'center'},
                {field: 'isShow', title: '是否显示',sort: true, width: 150, align: 'center', unresize: true, templet: '#isShow'},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 100, align: 'center'},
            ]],
            done: function (res, curr) {
                curr_page = curr;
            }
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                }
            });
            $('.card-box').addClass('hidden');
            $('.card-box').eq(0).removeClass('hidden');
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {'nav': id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {nav: id}) : route_url.save;
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

    layui.use('form', function () {
        layui.form.render();

        layui.form.on('switch(switchShow)', function (obj) {
            var url = Common.getRealRoutePath(route_url.set_show, {nav: this.value});
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
        search = {};
        var form = document.forms['navsSearch'];
        if (form.name.value)
            search.name = form.name.value;
        if (form.type.value)
            search.type = form.type.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>