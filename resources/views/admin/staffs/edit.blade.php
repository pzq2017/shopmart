<div class="toolbar">
   <button class="btn btn-blue f-right" onclick="saveStaff({{ $staff->id }})">保存</button>
   <button class="btn f-left" onclick="goBack('{{ route('admin.staffs.index') }}')">返回</button>
   <div class="f-clear"></div>
</div>
<div id="maingrid">
  <form autocomplete='off'>
    <input type="hidden" name="id" class="ipt" value="{{ $staff->id }}">
    <table class='table-form' style="margin-top: 10px;">
      <tr>
         <th class="w120">登录账号<font color='red'>*</font>:</th>
         <td><input type="text" name='loginName' value="{{ $staff->loginName }}" class='ipt' maxLength='20'/></td>
      </tr>
      <tr>
         <th>登录密码<font color='red'>*</font>:</th>
         <td><input type="password" name='password' class='ipt' maxLength='20'/></td>
      </tr>
      <tr>
         <th>职员姓名<font color='red'>*</font>:</th>
         <td><input type="text" name='staffName' value="{{ $staff->staffName }}" class='ipt'/></td>
      </tr>
      <tr>
         <th>职员照片:</th>
         <td>
            <input type="hidden" name="staffPhoto" value="{{ $staff->staffPhoto }}" id="staffPhoto" class='ipt'>
            <div class="file_picture_preview">
                @if ($staff->staffPhoto)
                  <img id="staffPhoto_preview" src="/file/{{ $staff->staffPhoto }}" width="100">
                @else
                  <img id="staffPhoto_preview" src="/imgs/gray.png" width="100">
                @endif
            </div>
            <div class="file_picture">
                <input type="file" name="file_staffPhoto" id="file_staffPhoto" onchange="Sigupload(this, 'picture', 'staffPhoto', '', '200*200', 2)">
            </div>
            <span class="upload_file_tips">(格式仅支持:jpg,png,jpeg，图片大小:200*200px)</span>
         </td>
      </tr>
      <tr>
         <th>所属角色:</th>
         <td>
            <select name="staffRoleId" class="ipt w120">
              <option value="">请选择角色</option>
              @foreach($roles as $role)
              <option value="{{ $role->id }}" {{ $staff->staffRoleId == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
              @endforeach
            </select>
          </td>
      </tr>
      <tr>
         <th>工作状态:</th>
         <td>
            <label>
              <input type="radio" name="workStatus" class="ipt l_radio" value="1" {{ $staff->workStatus == 1 ? 'checked' : '' }}>在职
            </label>
            <label>
              <input type="radio" name="workStatus" class="ipt l_radio" value="0" {{ $staff->workStatus == 0 ? 'checked' : '' }}>离职
            </label>
         </td>
      </tr>
      <tr>
         <th>账号状态:</th>
         <td>
            <label>
              <input type="radio" name="staffStatus" class="ipt l_radio" value="1" {{ $staff->staffStatus == 1 ? 'checked' : '' }}>开启
            </label> 
            <label>
              <input type="radio" name="staffStatus" class="ipt l_radio" value="0" {{ $staff->staffStatus == 0 ? 'checked' : '' }}>停用
            </label>
         </td>
      </tr>
    </table>
  </form>
</div>