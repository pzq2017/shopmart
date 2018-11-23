@section('search')
    <div class="layui-form layui-card-header card-header-auto">
        <form name="logSearch" onsubmit="return false;">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">登录员账号</label>
                    <div class="layui-input-block">
                        <input type="text" name="loginName" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">登录日期</label>
                    <div class="layui-input-block">
                        <input type="text" name="dateRange" autocomplete="off" class="layui-input" id="dateRange" style="width: 300px;">
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
@extends('admin.layout')
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.system.log.lists') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'staffId', title: '登录员', align: 'center', templet: function (data) {
                    if (data && data.staff) {
                        return data.staff.loginName;
                    }
                    return '';
                }},
                {field: 'created_at', title: '登录时间', sort: true, align: 'center'},
                {field: 'loginIp', title: '登录IP', align: 'center'},
            ]],
            done: function (res, curr) {
                curr_page = curr;
            }
        });
    }

    layui.use('laydate', function () {
        layui.laydate.render({
            elem: '#dateRange',
            type: 'datetime',
            range: '~',
            format: 'yyyy-M-dd HH:mm:ss'
        })
    })

    function Search() {
        search = {};
        var form = document.forms['logSearch'];
        if (form.loginName.value)
            search.loginName = form.loginName.value;
        if (form.dateRange.value)
            search.dateRange = form.dateRange.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>