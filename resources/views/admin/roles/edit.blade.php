<div class="toolbar">
   <button class="btn btn-blue f-right" onclick="saveRole({{ $role->id }})">保存</button>
   <button class="btn f-left" onclick="goBack('{{ route('admin.roles.index') }}')">返回</button>
   <div class="f-clear"></div>
</div>
<div id="maingrid">
  <form autocomplete='off'>
    <table class='table-form' style="margin-top: 10px;">
      <tr>
         <th class="w120">角色名称<font color='red'>*</font>:</th>
         <td><input type="text" name='name' value="{{ $role->name }}" class='ipt' maxLength='20'/></td>
      </tr>
      <tr>
         <th>角色备注:</th>
         <td><input type="text" name='desc' value="{{ $role->desc }}" class='ipt' style='width:70%' maxLength='100'/></td>
      </tr>
      <tr>
         <th>权限:</th>
         <td>
            <input type="hidden" id="menus_privileges" value="{{ $sysMenus }}">
            <ul id="menuTree" class="ztree ztree_panel"></ul>
         </td>
      </tr>
    </table>
  </form>
</div>
<script type="text/javascript">
  var zTree;
  $(function(){
    var setting = {
      check: {
        enable: true
      }
    };
    var zNodes = $('#menus_privileges').val();
    if (zNodes) {
      zNodes = eval('(' + zNodes + ')');
      $.fn.zTree.init($('#menuTree'), setting, zNodes);
      zTree = $.fn.zTree.getZTreeObj('menuTree');
    }
  })
</script>