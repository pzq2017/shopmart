<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-form layui-card-header card-header-auto">
                        <form name="adPositionsSearch" onsubmit="return false;">
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">广告位置名称</label>
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
    var params = {};
    var route_url = {
        index: '{{ route('admin.config.ad_position.index') }}',
        lists: '{{ route('admin.config.ad_position.lists') }}',
        create: '{{ route('admin.config.ad_position.create') }}',
        save: '{{ route('admin.config.ad_position.store') }}',
        edit: '{{ route_uri('admin.config.ad_position.edit') }}',
        update: '{{ route_uri('admin.config.ad_position.update') }}',
        delete: '{{ route_uri('admin.config.ad_position.destroy') }}',
    };
    function Lists() {
        Common.dataTableRender({
            url: route_url.lists,
            param: params,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '位置名称', align: 'center'},
                {field: 'width', title: '建议宽度(px)', align: 'center'},
                {field: 'height', title: '建议高度(px)', align: 'center'},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
            ]],
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {ad_position: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('#content_box').html(page);
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {ad_position: id}) : route_url.save;
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
            title: '删除广告位置',
            content: '您确定要删除当前广告位置信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {ad_position: id}), null, 'DELETE', function (data) {
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

    function Search() {
        params = {};
        var form = document.forms['adPositionsSearch'];
        if (form.name.value)
            params.name = form.name.value;
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>