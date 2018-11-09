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
<script type="text/javascript">
    var params = {'_token': baseParams.csrf_token, 'pid': {{ $pid }}};
    function Lists() {
        layui.use('table', function () {
            var table = layui.table;
            table.render({
                elem: '#list-datas',
                url: '{{ route('admin.config.area.lists') }}',
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
                    {field: 'id', title: 'ID', type: 'numbers', sort: true, width: 60, align: 'center'},
                    {field: 'name', title: '地区名称', align: 'center'},
                    {field: 'first_letter', title: '名称首字母', align: 'center'},
                    {field: 'isShow', title: '是否显示', width: 120, align: 'center', templet: function (data) {
                        return data.isShow == 1 ? '显示' : '隐藏';
                    }},
                    {field: 'sort', title: '排序号', width: 80, align: 'center'},
                    {field: 'created_at', title: '创建日期',sort: true, width: 180, align: 'center'},
                    {title: '操作', width: 200, align: 'center', templet: function (data) {
                        var html = '';
                            if (data.type < {{ \App\Models\Area::TYPE_DISTRICT }} ) {
                                html += '<a class="layui-btn layui-btn-xs" lay-event="view">查看</a>';
                            }
                            html += '<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>';
                            html += '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>';
                        return html;
                    }},
                ]],
                text: {
                    none: '暂无数据...'
                },
            });

            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                } else if (event == 'delete') {
                    Delete(data.id);
                } else if (event == 'view') {
                    $('#back_grade').attr('prev', data.pid);
                    params.pid = data.id;
                    Lists();
                }
            })
        })
    }

    function Edit(id) {
        var url = id ? Qk.getRealRoutePath('{{ route_uri('admin.config.area.edit') }}', {area: id}) : Qk.getRealRoutePath('{{ route_uri('admin.config.area.create') }}', {pid: params.pid});
        Qk.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Qk.getRealRoutePath('{{ route_uri('admin.config.area.update') }}', {area: id}) : '{{ route('admin.config.area.store') }}';
        Qk.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Qk.msg('保存成功!', {icon: 1}, function () {
                    goBack(Qk.getRealRoutePath('{{ route_uri('admin.config.area.index') }}', {pid: params.pid}));
                });
            } else {
                Qk.msg(data.info, {icon: 2});
            }
        }, function (errors) {
            alertErrors(errors);
        });
    }

    function Delete(id) {
        var confirm_dialog = Qk.confirm({
            title: '删除地区',
            content: '您确定要删除当前地区信息吗？',
            yes: function () {
                loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Qk.ajaxRequest(Qk.getRealRoutePath('{{ route_uri('admin.config.area.destroy') }}', {area: id}), null, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Qk.close(confirm_dialog);
                        Qk.msg("删除成功！", {icon: 1}, function () {
                            Lists();
                        });
                    } else {
                        Qk.msg(data.info, {icon: 2});
                    }
                }, function (errors) {
                    Qk.msg(errors, {icon: 2});
                });
            }
        })
    }

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