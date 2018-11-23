@section('handle_button')
    <div><button class="layui-btn" onclick="Edit(0)">新增</button></div>
@endsection
@extends('admin.layout')
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isPublish">
    <input type="checkbox" name="status" value="@{{ d.id }}" lay-filter="status" title="发布" @{{ d.status ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.article.category.lists') }}',
        create: '{{ route('admin.article.category.create') }}',
        save: '{{ route('admin.article.category.store') }}',
        edit: '{{ route_uri('admin.article.category.edit') }}',
        update: '{{ route_uri('admin.article.category.update') }}',
        delete: '{{ route_uri('admin.article.category.destroy') }}',
        publish: '{{ route_uri('admin.article.category.publish') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '名称', align: 'center'},
                {field: 'type', title: '类型', align: 'center', templet: function (data) {
                    var typeName = '';
                    switch (data.type)
                    {
                        case {{ \App\Models\ArticleCategory::TYPE_SINGLE }} :
                            typeName = '单页';
                            break;
                        case {{ \App\Models\ArticleCategory::TYPE_TEXT_LIST }} :
                            typeName = '文字列表';
                            break;
                        case {{ \App\Models\ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST }} :
                            typeName = '图文列表';
                            break;
                    }
                    return typeName;
                }},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'status', title: '发布状态', width: 200, align: 'center', unresize: true, templet: '#isPublish'},
                {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
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
        var url = id ? Common.getRealRoutePath(route_url.edit, {category: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {category: id}) : route_url.save;
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
            title: '删除分类',
            content: '您确定要删除当前分类信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {category: id}), null, 'DELETE', function (data) {
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
        layui.form.on('checkbox(status)', function (obj) {
            var url = Common.getRealRoutePath(route_url.publish, {category: this.value});
            Common.ajaxRequest(url, {publish: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败');
                }
            });
        });
    })

    $(document).ready(function () {
        Lists(1);
    });
</script>