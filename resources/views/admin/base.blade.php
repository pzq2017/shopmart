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
        var baseParams = {csrf_token: '{{ csrf_token() }}', upload_url: '{{ route('admin.sigupload.picture') }}'};
    </script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
        <ul class="layui-nav layui-layout-left">
            @foreach($base['header_menus'] as $menu)
            <li class="layui-nav-item"><a href="{{ $menu->url }}">{{ $menu->name }}</a></li>
            @endforeach
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="/imgs/default_headpic.png" class="layui-nav-img">
                    贤心<span class="layui-nav-more"></span></a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd><hr>
                    <dd><a href="">修改密码</a></dd><hr>
                    <dd><a href="">退出系统</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    @include('admin.sidebar', ['menus' => $base['sidebar_menus'] ])
    <div class="layui-body" id="content_body">
        @yield('body')
    </div>
</div>
<div id='editPwdBox' style='display:none;'>
  <form id='editPwdForm' autocomplete="off">
   <table class='table-form'>
      <tr>
         <th style="width: 100px;">原密码<font color='red'>*</font>：</th>
         <td><input type='password' name='oldPwd' class='ipwd' maxLength='16'/></td>
      </tr>
      <tr>
         <th>新密码<font color='red'>*</font>：</th>
         <td><input type='password' name='newPwd' class='ipwd' maxLength='16'/></td>
      </tr>
      <tr>
         <th>确认密码<font color='red'>*</font>：</th>
         <td><input type='password' name='newPwd_confirmation' class='ipwd' maxLength='16'/></td>
      </tr>
   </table>
  </form>
</div>
<script>
    layui.use('element');
</script>
</body>
</html>