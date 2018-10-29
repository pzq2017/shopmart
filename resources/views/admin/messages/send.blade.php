<div class="toolbar">
   <button class="btn btn-blue f-right" onclick="sendMessages()">发送</button>
   <button class="btn f-left" onclick="goBack('{{ route('admin.messages.index') }}')">返回</button>
   <div class="f-clear"></div>
</div>
<div id="maingrid">
  <form autocomplete='off'>
    <table class='table-form' style="margin-top: 10px;">
      <tr>
         <th>接收类型:<font color="red">*</font></th>
         <td>
             <input type="radio" name="receiver" value="1">会员
             <input type="radio" name="receiver" value="2">店铺
             <input type="radio" name="receiver" value="3">指定账号
         </td>
      </tr>
      </tr>
    </table>
  </form>
</div>