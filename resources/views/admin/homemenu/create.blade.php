<form id='homemenuForm'>
  <input type="hidden" name="parentId" class="ipt" value="{{ $parentId }}">
  <table class='table-form'>
   <tr>
      <th>菜单名称<font color='red'>*</font>：</th>
      <td>
          <input type="text" name="name" class="ipt" maxLength='20' />
      </td>
   </tr>
   <tr>
      <th>菜单链接<font color='red'>*</font>：</th>
      <td>
          <input type="text" name="url" class="ipt" maxLength='200' style='width:300px'/>
      </td>
   </tr>
   <tr>
      <th>附加资源：</th>
      <td>
          <textarea name="otherUrl" class="ipt" style='width:80%'></textarea>
      </td>
   </tr>
   <tr>
      <th>菜单类型<font color='red'>*</font>：</th>
        <td>
          <select name="type" class="ipt">
            @foreach($types as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
            @endforeach
          </select>
        </td>
    </tr>
   <tr>
      <th>菜单排序：</th>
      <td>
          <input type="text" name="sort" class="ipt" maxLength='10' />
      </td>
   </tr>
   <tr>
      <th>是否显示<font color='red'>*</font>：</th>
      <td>
        <lable>
          <input type="radio" name="isShow" value="1" class="ipt"/>显示
        </lable>
        <lable>
          <input type="radio" name="isShow" value="0" class="ipt" checked />隐藏
        </lable>
      </td>
   </tr>
  </table>
</form>