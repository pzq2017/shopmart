<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
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
</script>
<script type="text/html" id="isShow">
    <input type="checkbox" name="isShow" value="@{{ d.id }}" lay-skin="switch" lay-filter="switchShow" lay-text="显示|隐藏" @{{ d.isShow ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var params = {};
    var route_url = {
        index: '{{ route('admin.config.nav.index') }}',
        lists: '{{ route('admin.config.nav.lists') }}',
        create: '{{ route('admin.config.nav.create') }}',
        save: '{{ route('admin.config.nav.store') }}',
        edit: '{{ route_uri('admin.config.nav.edit') }}',
        update: '{{ route_uri('admin.config.nav.update') }}',
        set_show: '{{ route_uri('admin.config.nav.set_show') }}'
    };
    function Lists() {
        Common.dataTableRender({
            url: route_url.lists,
            param: params,
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
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {'nav': id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {nav: id}) : route_url.save;
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
        if (params.name) params.name = '';
        if (params.type) params.type = '';
        var form = document.forms['navsSearch'];
        if (form.name.value)
            params.name = form.name.value;
        if (form.type.value)
            params.type = form.type.value;
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>