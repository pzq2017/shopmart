<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-card-body">
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
                url: '{{ route('admin.config.payment_config.lists') }}',
                where: params,
                page: false,
                parseData: function (res) {
                    return {
                        "code" : 0,
                        "data" : res.message
                    }
                },
                cols: [[
                    {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                    {field: 'name', title: '支付名称', align: 'center'},
                    {field: 'desc', title: '支付描述', align: 'center'},
                    {field: 'online', title: '线上/线下支付', align: 'center', templet: function (data) {
                        return data.online == 1 ? '线上' : '线下';
                    }},
                    {field: 'enabled', title: '是否开启调试', align: 'center', templet: function (data) {
                        var html = '<input type="checkbox" name="debug" value="'+data.id+'" lay-skin="switch" lay-filter="switchDebug" lay-text="开启|关闭" '+(data.debug ? 'checked' : '')+'>';
                        return html;
                    }},
                    {field: 'enabled', title: '是否启用', align: 'center', templet: function (data) {
                        var html = '<input type="checkbox" name="enabled" value="'+data.id+'" title="启用" lay-filter="enabled" '+(data.enabled ? 'checked' : '')+'>';
                        return html;
                    }},
                    {field: 'updated_at', title: '更新日期',sort: true, width: 200, align: 'center'},
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
        var url = Common.getRealRoutePath('{{ route_uri('admin.config.payment_config.edit') }}', {payment_config: id});
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = Common.getRealRoutePath('{{ route_uri('admin.config.payment_config.update') }}', {payment_config: id});
        Common.ajaxRequest(saveUrl, form_datas, 'PUT', function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    goBack('{{ route('admin.config.payment_config.index') }}');
                });
            } else {
                Common.msg(data.info, {icon: 2});
            }
        }, function (errors) {
            alertErrors(errors);
        });
    }

    layui.use('form', function () {
        layui.form.on('checkbox(enabled)', function (obj) {
            var url = Common.getRealRoutePath('{{ route_uri('admin.config.payment_config.enabled') }}', {payment_config: this.value});
            Common.ajaxRequest(url, {enabled: obj.elem.checked}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.msg('设置失败', {icon: 2});
                }
            }, function (errors) {
                alertErrors(errors);
            });
        });

        layui.form.on('switch(switchDebug)', function (obj) {
            var url = Common.getRealRoutePath('{{ route_uri('admin.config.payment_config.debug') }}', {payment_config: this.value});
            Common.ajaxRequest(url, {debug: obj.elem.checked}, 'PUT', function (data) {
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

    $(document).ready(function () {
        Lists();
    });
</script>