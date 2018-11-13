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
<script type="text/javascript">
    var params = {'_token': baseParams.csrf_token};
    function Lists() {
        layui.use('table', function () {
            var table = layui.table;
            table.render({
                elem: '#list-datas',
                url: '{{ route('admin.config.friend_link.lists') }}',
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
                    {field: 'name', title: '友情链接名称', align: 'center', templet: function (data) {
                        return '<a href="'+data.link+'" target="_blank">'+data.name+'</a>';
                    }},
                    {field: 'ico', title: '图标', align: 'center', templet: function (data) {
                        return '<img src="/file/'+data.ico+'">';
                    }},
                    {field: 'sort', title: '排序号', width: 80, align: 'center'},
                    {field: 'status', title: '是否显示', width: 120, align: 'center', unresize: true, templet: function (data) {
                        return '<input type="checkbox" name="isShow" value="'+data.id+'" title="显示" lay-filter="isShow" '+(data.isShow ? 'checked' : '')+'>';
                    }},
                    {field: 'created_at', title: '创建日期',sort: true, width: 180, align: 'center'},
                    {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
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
                }
            })
        })
    }

    function Edit(id) {
        var url = id ? Qk.getRealRoutePath('{{ route_uri('admin.config.friend_link.edit') }}', {friend_link: id}) : '{{ route('admin.config.friend_link.create') }}';
        Qk.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Qk.getRealRoutePath('{{ route_uri('admin.config.friend_link.update') }}', {friend_link: id}) : '{{ route('admin.config.friend_link.store') }}';
        Qk.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Qk.msg('保存成功!', {icon: 1}, function () {
                    goBack('{{ route('admin.config.friend_link.index') }}');
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
            title: '删除友情链接',
            content: '您确定要删除当前友情链接信息吗？',
            yes: function () {
                loading = Qk.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Qk.ajaxRequest(Qk.getRealRoutePath('{{ route_uri('admin.config.friend_link.destroy') }}', {friend_link: id}), null, 'DELETE', function (data) {
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

    layui.use('form', function () {
        layui.form.on('checkbox(isShow)', function (obj) {
            var url = Qk.getRealRoutePath('{{ route_uri('admin.config.friend_link.is_show') }}', {friend_link: this.value});
            Qk.ajaxRequest(url, {isShow: obj.elem.checked}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Qk.msg('设置成功!', {icon: 1});
                } else {
                    Qk.msg('设置失败', {icon: 2});
                }
            }, function (errors) {
                alertErrors(errors);
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