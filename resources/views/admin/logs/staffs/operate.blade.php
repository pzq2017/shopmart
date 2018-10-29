<style type="text/css">
	.l-text-wrapper{width:168px; float:left;}
	.l-text-date{margin: 0px; height: 27px;}
	input[type="text"].sear_inp{width: 150px; margin: 0px;}
</style>
<script>
    var logsUrl = {
        index: '{{ route_uri('admin.logs.staffs.operate') }}',
    };
	var logType = 2;
</script>
<script type="text/javascript" src="/js/admin/logs.js"></script>
<div id="pagebody">
	<div class="toolbar">
     	<button class="btn btn-blue f-right" style="margin: 2px;" onclick='searchLogs()'>搜索</button>
     	<div style="width:620px; height: 30px;" class="m_right_10 f-right">
     		<table cellpadding="0" cellspacing="0" style="height: 30px;">
     			<tr>
     				<td>职员账号：</td>
     				<td>
     					<input type='text' name='loginName' class='ipsearch' style="width:120px;" />
     				</td>
     				<td width="20"></td>
     				<td>操作时间：</td>
     				<td>
     					<input type='text' name='startDate' placeholder="起始时间" id="startDate" class='ipsearch sear_inp' />
     				</td>
     				<td>
     					<input type='text' name='endDate' placeholder="结束时间" id="endDate" class='ipsearch sear_inp'/>
     				</td>
     			</tr>
     		</table>
     	</div>
	   	<div class="f-clear"></div>
	</div>
	<div id="maingrid"></div>
</div>