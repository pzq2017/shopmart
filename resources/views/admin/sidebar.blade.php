<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree" lay-shrink="all">
            @foreach($menus as $menu)
            <li class="layui-nav-item">
                @if($menu->subChildMenu)
                    <a href="javascript:void(0);">{{ $menu->name }}<span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        @foreach($menu->subChildMenu as $childMenu)
                            <dd><a class="menu_item" href="javascript:void(0);" url="{{ $childMenu->url }}">{{ $childMenu->name }}</a></dd>
                        @endforeach
                    </dl>
                @else
                    <a class="menu_item" href="javascript:void(0);" url="{{ $menu->url }}">{{ $menu->name }}</a>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.menu_item').click(function () {
            var target_url = $(this).attr('url');
            if (!target_url) return;
            Common.loadPage(target_url, {}, function (page) {
                $('#content_body').html(page);
            })
        });
    })
</script>