<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="goBack('{{ route('admin.config.nav.index') }}')">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $nav->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">导航位置:</label>
            <div class="layui-input-inline">
                <select name="type" lay-verify="required">
                    @foreach(\App\Models\Navs::NAVS_POSITIONS as $index => $pos)
                        <option value="{{ $index }}" {{ $nav->type == $index ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">导航名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $nav->name }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">导航链接:</label>
            <div class="layui-input-block">
                <input type="text" name="url" value="{{ $nav->url }}" lay-verify="required" autocomplete="off" class="layui-input width-per-50">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">链接打开方式:</label>
            <div class="layui-input-block">
                <input type="radio" name="isTarget" value="0" title="页面跳转" {{ $nav->isTarget == 0 ? 'checked' : '' }}>
                <input type="radio" name="isTarget" value="1" title="新窗口打开" {{ $nav->isTarget == 1 ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示:</label>
            <div class="layui-input-block">
                <input type="radio" name="isShow" value="1" title="显示" {{ $nav->isShow == \App\Models\Navs::NAVS_SHOW ? 'checked' : '' }}>
                <input type="radio" name="isShow" value="0" title="隐藏" {{ $nav->isShow == \App\Models\Navs::NAVS_NOT_SHOW ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">导航排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" value="{{ $nav->sort }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="navs_info">更新</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form'], function () {
        var form = layui.form;
        form.render();

        form.on('submit(navs_info)', function (data) {
            Save('{{ $nav->id }}', data.field);
        });
    })
</script>