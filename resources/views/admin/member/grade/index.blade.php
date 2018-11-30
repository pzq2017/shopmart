@section('handle_button')
    <div><button class="layui-btn" onclick="Edit(0)">新增</button></div>
@endsection
@extends('admin.layout')
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.member.grade.lists') }}',
        create: '{{ route('admin.member.grade.create') }}',
        save: '{{ route('admin.member.grade.store') }}',
        edit: '{{ route_uri('admin.member.grade.edit') }}',
        update: '{{ route_uri('admin.member.grade.update') }}',
    };
    function Lists() {
        Common.dataTableRender(1, {
            url: route_url.lists,
            where: search,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '名称', align: 'center'},
                {field: 'icon', title: '图标', width: 200, align: 'center', templet: function (data) {
                    return '<img src="/file/'+data.icon+'" style="height: 25px;">';
                }},
                {field: 'min_score', title: '积分下限', width: 100, align: 'center'},
                {field: 'max_score', title: '积分上限', width: 100, align: 'center'},
                {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
            ]],
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                }
            });
            $('.card-box').addClass('hidden');
            $('.card-box').eq(0).removeClass('hidden');
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {grade: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {grade: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    Lists();
                });
            } else {
                Common.alertErrors(data.info);
            }
        });
    }

    $(document).ready(function () {
        Lists();
    });
</script>