<script>
    var messagesUrl = {
        index: '{{ route_uri('admin.messages.index') }}',
        create: '{{ route_uri('admin.messages.create') }}',
        store: '{{ route_uri('admin.messages.store') }}',
        edit: '{{ route_uri('admin.messages.edit') }}',
        update: '{{ route_uri('admin.messages.update') }}',
        destroy: '{{ route_uri('admin.messages.destroy') }}',
        sendSet: '{{ route_uri('admin.messages.sendSet') }}}',
        send: '{{ route_uri('admin.messages.send') }}}',
    };
</script>
<script type="text/javascript" src="/js/admin/messages.js"></script>
<div id="pagebody">
    <div class="toolbar">
        <button class="btn btn-green f-right" onclick='addMessages()'>新增</button>
        <div class="f-clear"></div>
    </div>
    <div id="maingrid"></div>
</div>