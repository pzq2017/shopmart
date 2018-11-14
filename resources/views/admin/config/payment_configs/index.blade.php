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
<script type="text/html" id="debug">
    <input type="checkbox" name="debug" value="@{{ d.id }}" lay-skin="switch" lay-filter="switchDebug" lay-text="开启|关闭" @{{ d.debug ? 'checked' : '' }}>
</script>
<script type="text/html" id="enabled">
    <input type="checkbox" name="enabled" value="@{{ d.id }}" title="启用" lay-filter="enabled" @{{ d.enabled ? 'checked' : '' }}>
</script>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
</script>
<script type="text/javascript">
    var params = {};
    var route_url = {
        index: '{{ route('admin.config.payment_config.index') }}',
        lists: '{{ route('admin.config.payment_config.lists') }}',
        edit: '{{ route_uri('admin.config.payment_config.edit') }}',
        update: '{{ route_uri('admin.config.payment_config.update') }}',
        enable: '{{ route_uri('admin.config.payment_config.enabled') }}',
        debug: '{{ route_uri('admin.config.payment_config.debug') }}',
    };
    function Lists() {
        Common.dataTableRender({
            url: route_url.lists,
            param: params,
            page: false,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '支付名称', align: 'center'},
                {field: 'desc', title: '支付描述', align: 'center'},
                {field: 'online', title: '线上/线下支付', align: 'center', templet: function (data) {
                    return data.online == 1 ? '线上' : '线下';
                }},
                {field: 'debug', title: '是否开启调试', align: 'center', unresize: true, templet: '#debug'},
                {field: 'enabled', title: '是否启用', align: 'center', unresize: true, templet: '#enabled'},
                {field: 'updated_at', title: '更新日期',sort: true, width: 200, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 100, align: 'center'},
            ]],
        });
    }

    function Edit(id) {
        var url = Common.getRealRoutePath(route_url.edit, {payment_config: id});
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = Common.getRealRoutePath(route_url.update, {payment_config: id});
        Common.ajaxRequest(saveUrl, form_datas, 'PUT', function (data) {
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
        layui.form.on('checkbox(enabled)', function (obj) {
            var url = Common.getRealRoutePath(route_url.enable, {payment_config: this.value});
            Common.ajaxRequest(url, {enabled: obj.elem.checked}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败');
                }
            });
        });

        layui.form.on('switch(switchDebug)', function (obj) {
            var url = Common.getRealRoutePath(route_url.debug, {payment_config: this.value});
            Common.ajaxRequest(url, {debug: obj.elem.checked}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败', {icon: 2});
                }
            });
        });
    })

    $(document).ready(function () {
        Lists();
    });
</script>