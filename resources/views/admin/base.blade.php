<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理中心 - 电子商务系统</title>
    <link href="/plugin/ligerui/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
    <link href="/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/js/jquery.min.js"></script>
    <script src="/plugin/ligerui/js/ligerui.all.js" type="text/javascript"></script>
    <script src='/plugin/layui/layui.all.js' type='text/javascript'></script>
    <script src="/js/common.js"></script>
    <script src="/js/admin/base.js"></script>
    <script>
        window.params = {csrf_token: '{{ csrf_token() }}', subMenusUrl: '{{ route('admin.subMenus') }}', defaultUrl: '{{ route('admin.main') }}', clearCacheUrl: '{{ route('admin.clearCache') }}', updPwdUrl: '{{ route('admin.updatPwd') }}', logoutUrl: '{{ route('admin.logout') }}'};
    </script>
</head>
<body>
<div id="topmenu" class="topmenu">
    <div class="topmenu-logo"></div>
    <div class="topmenu-welcome">
        <a href="#" target='_blank' class="top-link">商城首页</a>
        <span class="space">|</span>
        <a href="javascript:clearCache();" class="top-link">清除缓存</a>
        <span class="space">|</span>
        <a href="javascript:editPwd();" class="top-link">修改密码</a>
        <span class="space">|</span>
        <a href="javascript:logout();" class="top-link">退出系统</a>
    </div>
</div>
<div id="tabs" style="width:100%; overflow: hidden; border: 1px solid #D3D3d3;" class="liger-tab">
    @foreach($base['header_menus'] as $menu)
        <div id="tab-{{ $menu->id }}" tabId="tab-{{ $menu->id }}" title="{{ $menu->name }}" class='tab'></div>
    @endforeach
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
<iframe name="iframe_upload" class="hidden"></iframe>
<form name="picture_upload_form" method="POST" enctype="multipart/form-data" target="iframe_upload" action="{{ route('admin.sigupload.picture') }}" class="hidden"></form>
</body>
</html>