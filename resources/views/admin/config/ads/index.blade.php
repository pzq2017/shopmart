@section('search')
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
@endsection
@section('handle_button')
    <div><button class="layui-btn" onclick="Edit(0)">新增</button></div>
@endsection
@extends('admin.layout')
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isPublish">
    <input type="checkbox" name="ad_publish" value="@{{ d.id }}" lay-filter="ad_publish" title="发布" @{{ d.publish_date ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        index: '{{ route('admin.config.ad.index') }}',
        lists: '{{ route('admin.config.ad.lists') }}',
        create: '{{ route('admin.config.ad.create') }}',
        save: '{{ route('admin.config.ad.store') }}',
        edit: '{{ route_uri('admin.config.ad.edit') }}',
        update: '{{ route_uri('admin.config.ad.update') }}',
        delete: '{{ route_uri('admin.config.ad.destroy') }}',
        publish: '{{ route_uri('admin.config.ad.update_publish_date') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
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
                {field: 'status', title: '发布状态', width: 120, align: 'center', unresize: true, templet: '#isPublish'},
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
        var url = id ? Common.getRealRoutePath(route_url.edit, {ad: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {ad: id}) : route_url.save;
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
            title: '删除广告',
            content: '您确定要删除当前广告信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {ad: id}), null, 'DELETE', function (data) {
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
        layui.form.render();

        layui.form.on('checkbox(ad_publish)', function (obj) {
            var url = Common.getRealRoutePath(route_url.publish, {ad: this.value});
            Common.ajaxRequest(url, {publish: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
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
        var form = document.forms['adsSearch'];
        if (form.name.value)
            search.name = form.name.value;
        if (form.posid.value)
            search.posid = form.posid.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>