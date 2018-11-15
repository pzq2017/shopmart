<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理中心 - 电子商务系统</title>
    <link href="/plugin/layui/css/layui.css" rel="stylesheet" type="text/css" />
    <link href="/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/js/jquery.min.js" type="text/javascript"></script>
    <script src='/plugin/layui/layui.js' type='text/javascript'></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/admin/base.js" type="text/javascript"></script>
    <script>
        var baseParams = {
            csrf_token: '{{ csrf_token() }}',
            upload_url: '{{ route('admin.sigupload.upload') }}',
            myinfo_url: '{{ route('admin.my_info') }}',
            change_password_url: '{{ route('admin.change_password') }}',
            logout_url: '{{ route('admin.logout') }}'
        };
    </script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
        <ul class="layui-nav layui-layout-left">
            @foreach($base['header_menus'] as $menu)
            <li class="layui-nav-item {{ Request::url() == $menu->url ? 'layui-this' : '' }}"><a href="{{ $menu->url }}">{{ $menu->name }}</a></li>
            @endforeach
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    @if(admin_auth()->staffPhoto)
                        <img src="/file/{{ admin_auth()->staffPhoto }}" class="layui-nav-img">
                    @else
                        <img src="/imgs/default_headpic.png" class="layui-nav-img">
                    @endif
                    {{ admin_auth()->loginName }}<span class="layui-nav-more"></span></a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:myInfo();">个人资料</a></dd><hr>
                    <dd><a href="javascript:editPwd();">修改密码</a></dd><hr>
                    <dd><a href="javascript:logout();">退出系统</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    @include('admin.sidebar', ['menus' => $base['sidebar_menus'] ])
    <div class="layui-body" id="content_body">
        @yield('body')
    </div>
</div>
<div id='editPwdBox' class="hidden">
    <div class="layui-card-body">
        <form class="layui-form" onsubmit="return false;">
            <div class="layui-form-item">
                <label class="layui-form-label">原密码<font color="red">*</font>:</label>
                <div class="layui-input-inline">
                    <input type="password" name="oldPwd" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">新密码<font color="red">*</font>:</label>
                <div class="layui-input-inline">
                    <input type="password" name="newPwd" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">确认密码<font color="red">*</font>:</label>
                <div class="layui-input-inline">
                    <input type="password" name="newPwd_confirmation" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="change_password">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use('element');
</script>
</body>
</html>