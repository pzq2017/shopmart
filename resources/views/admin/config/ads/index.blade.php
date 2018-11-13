<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-form layui-card-header card-header-auto">
                        <form name="adsSearch" onsubmit="return false;">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">广告名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="name" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">广告位置</label>
                                    <div class="layui-input-block">
                                        <select name="posid">
                                            <option value="">请选择位置</option>
                                            @foreach($ad_positions as $ad_position)
                                                <option value="{{ $ad_position->id }}">{{ $ad_position->name }}</option>
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
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/javascript">
    var params = {'_token': baseParams.csrf_token};
    function Lists() {
        layui.use('table', function () {
            var table = layui.table;
            table.render({
                elem: '#list-datas',
                url: '{{ route('admin.config.ad.lists') }}',
                where: params,
                page: true,
                limit: Const.defaultPageSize,
                limits: Const.defaultPageSizeOptions,
                parseData: function (res) {
                    return {
                        "code" : 0,
                        "data" : res.message.lists,
                        "count": res.message.total,
                    }
                },
                cols: [[
                    {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                    {field: 'name', title: '广告名称', align: 'center'},
                    {field: 'posid', title: '广告位置', align: 'center', templet: function (data) {
                        if (data.ad_positions) {
                            return data.ad_positions.name;
                        }
                        return '';
                    }},
                    {field: 'url', title: '广告链接', align: 'center'},
                    {field: 'date', title: '广告日期', align: 'center', templet: function (data) {
                        return data.start_date + '~' + data.end_date;
                    }},
                    {field: 'image_path', title: '广告图', align: 'center', templet: function (data) {
                        return '<a href="/file/'+data.image_path+'" target="_blank"><img src="/file/'+data.image_path+'"></a>';
                    }},
                    {field: 'click_num', title: '点击数', width: 80, align: 'center'},
                    {field: 'sort', title: '排序号', width: 80, align: 'center'},
                    {field: 'status', title: '发布状态', width: 120, align: 'center', unresize: true, templet: function (data) {
                        var html = '<input type="checkbox" name="ad_publish" value="'+data.id+'" title="发布" lay-filter="ad_publish" '+(data.publish_date ? 'checked' : '')+'>';
                        return html;
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
        var url = id ? Common.getRealRoutePath('{{ route_uri('admin.config.ad.edit') }}', {ad: id}) : '{{ route('admin.config.ad.create') }}';
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath('{{ route_uri('admin.config.ad.update') }}', {ad: id}) : '{{ route('admin.config.ad.store') }}';
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    goBack('{{ route('admin.config.ad.index') }}');
                });
            } else {
                Common.msg(data.info, {icon: 2});
            }
        }, function (errors) {
            alertErrors(errors);
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除广告',
            content: '您确定要删除当前广告信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath('{{ route_uri('admin.config.ad.destroy') }}', {ad: id}), null, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Common.close(confirm_dialog);
                        Common.msg("删除成功！", {icon: 1}, function () {
                            Lists();
                        });
                    } else {
                        Common.msg(data.info, {icon: 2});
                    }
                }, function (errors) {
                    alertErrors(errors);
                });
            }
        })
    }

    layui.use('form', function () {
        layui.form.render();

        layui.form.on('checkbox(ad_publish)', function (obj) {
            var url = Common.getRealRoutePath('{{ route_uri('admin.config.ad.update_publish_date') }}', {ad: this.value});
            Common.ajaxRequest(url, {publish: obj.elem.checked}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.msg('设置失败', {icon: 2});
                }
            }, function (errors) {
                alertErrors(errors);
            });
        });
    })

    function Search() {
        if (params.name) params.name = '';
        if (params.posid) params.posid = '';
        var form = document.forms['adsSearch'];
        if (form.name.value)
            params.name = form.name.value;
        if (form.posid.value)
            params.posid = form.posid.value;
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>