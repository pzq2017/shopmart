<script>
    var rolesUrl = {
        index: '{{ route_uri('admin.roles.index') }}',
        create: '{{ route_uri('admin.roles.create') }}',
        store: '{{ route_uri('admin.roles.store') }}',
        edit: '{{ route_uri('admin.roles.edit') }}',
        update: '{{ route_uri('admin.roles.update') }}',
        destroy: '{{ route_uri('admin.roles.destroy') }}'
    };
</script>
<link href="/plugin/ztree/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/plugin/ztree/jquery.ztree.all-3.5.js"></script>
<script type="text/javascript" src="/js/admin/roles.js"></script>
<div id="pagebody">
	<div class="toolbar">
	   <button class="btn btn-green f-right" onclick='addRole()'>新增</button>
	   <div class="f-clear"></div>
	</div>
	<div id="maingrid"></div>
</div>