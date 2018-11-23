@section('search')
    <div class="layui-form layui-card-header card-header-auto">
        <form name="articleSearch" onsubmit="return false;">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-block">
                        <select name="types" lay-filter="article_category">
                            <option value="">请选择</option>
                            <option value="{{ \App\Models\ArticleCategory::TYPE_SINGLE }}">单页</option>
                            <option value="{{ \App\Models\ArticleCategory::TYPE_TEXT_LIST }}">文字列表</option>
                            <option value="{{ \App\Models\ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST }}">图文列表</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" autocomplete="off" class="layui-input">
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
<link rel="stylesheet" href="/plugin/kindeditor/themes/default/default.css">
<script type="text/javascript" src="/plugin/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="/plugin/kindeditor/lang/zh-CN.js"></script>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isPublish">
    <input type="checkbox" name="publish" value="@{{ d.id }}" lay-filter="publish" title="发布" @{{ d.pub_date ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1, editor;
    var route_url = {
        lists: '{{ route('admin.article.lists') }}',
        create: '{{ route('admin.article.create') }}',
        save: '{{ route('admin.article.store') }}',
        edit: '{{ route_uri('admin.article.edit') }}',
        update: '{{ route_uri('admin.article.update') }}',
        delete: '{{ route_uri('admin.article.destroy') }}',
        publish: '{{ route_uri('admin.article.publish') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'catid', title: '类别', width: 150, align: 'center', templet: function (data) {
                    return data.category ? data.category.name : '';
                }},
                {field: 'title', title: '标题', align: 'center'},
                {field: 'author', title: '作者', width: 100, align: 'center'},
                {field: 'view_count', title: '浏览次数', width: 100, align: 'center'},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'status', title: '发布状态', width: 120, align: 'center', unresize: true, templet: '#isPublish'},
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
                } else if (event == 'del') {
                    Delete(data.id);
                }
            });
            $('.card-box').addClass('hidden');
            $('.card-box').eq(0).removeClass('hidden');
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {article: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
            editor = KindEditor.create('textarea[name="text"]', {width: '90%', height: '400px', filterMode: false});
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {article: id}) : route_url.save;
        form_datas.text = editor.html();
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
            title: '删除文章',
            content: '您确定要删除当前文章信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {article: id}), null, 'DELETE', function (data) {
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
        layui.form.on('checkbox(publish)', function (obj) {
            var url = Common.getRealRoutePath(route_url.publish, {article: this.value});
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
        var form = document.forms['articleSearch'];
        if (form.title.value)
            search.title = form.title.value;
        if (form.types.value)
            search.types = form.types.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>