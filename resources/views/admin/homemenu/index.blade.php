<script>
    var homemenuUrl = {
        index: '{{ route_uri('admin.homemenu.index') }}',
        create: '{{ route_uri('admin.homemenu.create') }}',
        store: '{{ route_uri('admin.homemenu.store') }}',
        edit: '{{ route_uri('admin.homemenu.edit') }}',
        update: '{{ route_uri('admin.homemenu.update') }}',
        destroy: '{{ route_uri('admin.homemenu.destroy') }}'
    };
</script>
<script type="text/javascript" src="/js/admin/gridtree.js"></script>
<script type="text/javascript" src="/js/admin/homemenu.js"></script>
<div class="toolbar">
   菜单类型：<select id='s_menuType'>
      <option value='0'>全部</option>
      @foreach($types as $key => $type)
      <option value='{{ $key }}'>{{ $type }}</option>
      @endforeach
   </select>
   <button class="btn btn-green f-right" onclick="addHomeMenu(0);">新增</button>
   <div style="clear:both"></div>
</div>
<div id="maingrid"></div>