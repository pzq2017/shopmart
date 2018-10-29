<form id='privilegeForm' autocomplete='off'>
    <input type="hidden" name="menuId" class="ipt" value="{{ $menuId }}">
    <table class='table-form'>
        <tr>
            <th width='100'>权限名称<font color='red'>*</font>：</th>
            <td><input type='text' name='name' class='ipt' maxLength='20'/></td>
        </tr>
        <tr>
            <th>权限代码<font color='red'>*</font>：</th>
            <td><input type='text' name='code' class='ipt' maxLength='20'/></td>
        </tr>
        <tr>
            <th>是否菜单权限<font color='red'>*</font>：</th>
            <td height='24'>
                <label>
                    <input type="radio" name="isMenu" class="ipt" value="1">是
                </label>
                <label>
                    <input type="radio" name="isMenu" class="ipt" value="0" checked>否
                </label>
            </td>
        </tr>
        <tr>
            <th>权限资源：</th>
            <td><input type='text' name='url' class='ipt' maxLength='100' style='width:90%'/></td>
        </tr>
        <tr>
            <th>关联资源：<br/>(以,号分隔)&nbsp;&nbsp;&nbsp;</th>
            <td>
                <textarea name='otherUrl' class='ipt' maxLength='100' style='width:90%; height:60px;'></textarea>
            </td>
        </tr>
    </table>
</form>