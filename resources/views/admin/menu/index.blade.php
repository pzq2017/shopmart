<link href="/plugin/ztree/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/plugin/ztree/jquery.ztree.all-3.5.js"></script>
<script>
    var menuUrl = {
        create: '{{ route_uri('admin.menu.create') }}',
        store: '{{ route_uri('admin.menu.store') }}',
        edit: '{{ route_uri('admin.menu.edit') }}',
        update: '{{ route_uri('admin.menu.update') }}',
        destroy: '{{ route_uri('admin.menu.destroy') }}',
        getSysMenusUrl: '{{ route_uri('admin.menu.getSysMenus') }}'
    };
    var privilegeUrl = {
        index: '{{ route_uri('admin.privileges.index') }}',
        create: '{{ route_uri('admin.privileges.create') }}',
        store: '{{ route_uri('admin.privileges.store') }}',
        edit: '{{ route_uri('admin.privileges.edit') }}',
        update: '{{ route_uri('admin.privileges.update') }}',
        destroy: '{{ route_uri('admin.privileges.destroy') }}'
    };
</script>
<script src="/js/admin/menu.js"></script>
<div id="layout">
    <div  position="left" title="菜单管理" showClose='true' style='overflow:auto'>
        <ul id="menuTree" class="ztree"></ul>
    </div>
    <div position="center" title="权限管理">
        <div class="toolbar" style='display:none'>
            <button class="btn btn-green f-right" onclick='javascript:addPrivilege();'>新增</button>
            <div style='clear:both'></div>
        </div>
        <div id="maingrid"  style='display:none'></div>
    </div>
</div>