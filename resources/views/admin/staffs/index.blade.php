<script>
    var staffsUrl = {
        index: '{{ route_uri('admin.staffs.index') }}',
        create: '{{ route_uri('admin.staffs.create') }}',
        store: '{{ route_uri('admin.staffs.store') }}',
        edit: '{{ route_uri('admin.staffs.edit') }}',
        update: '{{ route_uri('admin.staffs.update') }}',
        destroy: '{{ route_uri('admin.staffs.destroy') }}'
    };
</script>
<script type="text/javascript" src="/js/admin/staffs.js"></script>
<div id="pagebody">
	<div class="toolbar">
       <button class="btn btn-blue f-right" onclick='searchStaff()'>搜索</button>
	   <button class="btn btn-green f-right m_right_10" onclick='addStaff()'>新增</button>
	   <div class="f-clear"></div>
	</div>
	<div id="maingrid"></div>
</div>
<div id='searchBox' style='display:none;'>
  <form id='searchForm' autocomplete="off">
   <table class='table-form'>
      <tr>
         <th style="width: 100px;">职员账号：</th>
         <td><input type='text' name='loginName' class='ipsearch'/></td>
      </tr>
      <tr>
         <th>职员名称：</th>
         <td><input type='text' name='staffName' class='ipsearch'/></td>
      </tr>
      <tr>
         <th>职员角色：</th>
         <td>
            @php
                $roles = App\Models\Roles::all();
            @endphp
            <select name='staffRoleId' class='ipsearch w120'>
                <option value="">请选择角色</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </td>
      </tr>
      <tr>
         <th>工作状态：</th>
         <td>
            <label>
              <input type="radio" name="workStatus" class="ipsearch l_radio" value="1">在职
            </label>
            <label>
              <input type="radio" name="workStatus" class="ipsearch l_radio" value="-1">离职
            </label>
         </td>
      </tr>
   </table>
  </form>
</div>