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
<script type="text/javascript">
    var params = {'_token': baseParams.csrf_token};
    function Lists() {
        layui.use('table', function () {
            var table = layui.table;
            table.render({
                elem: '#list-datas',
                url: '{{ route('admin.config.nav.lists') }}',
                where: params,
                page: true,
                limit: Qk.defaultPageSize,
                limits: Qk.defaultPageSizeOptions,
                parseData: function (res) {
                    return {
                        "code" : 0,
                        "data" : res.message.lists,
                        "count": res.message.total,
                    }
                },
                cols: [[
                    {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                    {field: 'type', title: '类型', sort: true, width: 150, align: 'center', templet: function (data) {
                        return data.typeName;
                    }},
                    {field: 'name', title: '名称', width: 200, align: 'center'},
                    {field: 'url', title: '链接', align: 'center'},
                    {field: 'isShow', title: '是否显示',sort: true, width: 100, align: 'center', templet: function (data) {
                        if (data.isShow == {{ \App\Models\Navs::NAVS_SHOW }}) {
                            return '显示';
                        }
                        return '隐藏';
                    }},
                    {field: 'sort', title: '排序号', width: 80, align: 'center'},
                    {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
                    {title: '操作', toolbar: '#actionBar', width: 100, align: 'center'},
                ]],
                text: {
                    none: '暂无数据...'
                },
            });

            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                }
            })
        })
    }

    function Edit(id) {
        var url = id ? Qk.getRealRoutePath('{{ route_uri('admin.config.nav.edit') }}', {'nav': id}) : '{{ route('admin.config.nav.create') }}';
        Qk.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Qk.getRealRoutePath('{{ route_uri('admin.config.nav.update') }}', {nav: id}) : '{{ route('admin.config.nav.store') }}';
        Qk.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Qk.msg('保存成功!', {icon: 1}, function () {
                    goBack('{{ route('admin.config.nav.index') }}');
                });
            } else {
                Qk.msg(data.info, {icon: 2});
            }
        }, function (errors) {
            alertErrors(errors);
        });
    }

    layui.use('form', function () {
        layui.form.render();
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