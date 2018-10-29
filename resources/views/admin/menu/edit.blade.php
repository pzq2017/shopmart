<form id='menuForm' autocomplete='off'>
    <input type="hidden" name="parentId" class="ipt2" value="{{ $menu->parentId }}">
    <table class='table-form'>
        <tr>
            <th width='100'>菜单名称<font color='red'>*</font>：</th>
            <td><input type='text' name='name' class='ipt2' value="{{ $menu->name }}" maxLength='20'/></td>
        </tr>
        <tr>
            <th width='100'>菜单排序：</th>
            <td><input type='text' name='sort' class='ipt2' value="{{ $menu->sort }}" maxLength='5'/></td>
        </tr>
    </table>
</form>