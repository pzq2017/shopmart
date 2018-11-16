<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
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
                    <div class="layui-card-body">
                        <table class="layui-hide" id="list-datas" lay-filter="list-datas"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var params = {};
    var route_url = {
        index: '{{ route('admin.system.log.index') }}',
        lists: '{{ route('admin.system.log.lists') }}',
    };
    function Lists() {
        Common.dataTableRender({
            url: route_url.lists,
            param: params,
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
        params = {};
        var form = document.forms['logSearch'];
        if (form.loginName.value)
            params.loginName = form.loginName.value;
        if (form.dateRange.value)
            params.dateRange = form.dateRange.value;
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>