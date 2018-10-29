<div class="toolbar">
   <button class="btn btn-blue f-right" onclick="saveMessages()">保存</button>
   <button class="btn f-left" onclick="goBack('{{ route('admin.messages.index') }}')">返回</button>
   <div class="f-clear"></div>
</div>
<link rel="stylesheet" href="/plugin/kindeditor/themes/default/default.css">
<script type="text/javascript" src="/plugin/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="/plugin/kindeditor/lang/zh-CN.js"></script>
<div id="maingrid">
  <form autocomplete='off'>
    <table class='table-form' style="margin-top: 10px;">
      <tr>
         <th>消息内容:<font color="red">*</font></th>
         <td>
            <textarea name="message" class='ipt'></textarea>
         </td>
      </tr>
      </tr>
    </table>
  </form>
</div>