<form id='homemenuForm'>
  <input type="hidden" name="parentId" class="ipt" value="{{ $homemenu->parentId }}">
  <table class='table-form'>
   <tr>
      <th>菜单名称<font color='red'>*</font>：</th>
      <td>
          <input type="text" name="name" class="ipt" value="{{ $homemenu->name }}" maxLength='20' />
      </td>
   </tr>
   <tr>
      <th>菜单链接<font color='red'>*</font>：</th>
      <td>
          <input type="text" name="url" class="ipt" value="{{ $homemenu->url }}" maxLength='200' style='width:300px'/>
      </td>
   </tr>
   <tr>
      <th>附加资源：</th>
      <td>
          <textarea name="otherUrl" class="ipt" value="{{ $homemenu->otherUrl }}" style='width:80%'></textarea>
      </td>
   </tr>
   <tr>
      <th>菜单类型<font color='red'>*</font>：</th>
        <td>
          <select name="type" class="ipt">
            @foreach($types as $id => $type)
            <option value="{{ $id }}" {{ $homemenu->type == $id ? 'selected' : ''}}>{{ $type }}</option>
            @endforeach
          </select>
        </td>
    </tr>
   <tr>
      <th>菜单排序：</th>
      <td>
          <input type="text" name="sort" class="ipt" value="{{ $homemenu->sort }}" maxLength='10' />
      </td>
   </tr>
   <tr>
      <th>是否显示<font color='red'>*</font>：</th>
      <td>
        <lable>
          <input type="radio" name="isShow" value="1" {{ $homemenu->isShow == 1 ? 'checked' : ''}} class="ipt"/>显示
        </lable>
        <lable>
          <input type="radio" name="isShow" value="0" class="ipt" {{ $homemenu->isShow == 0 ? 'checked' : ''}} />隐藏
        </lable>
      </td>
   </tr>
  </table>
</form>