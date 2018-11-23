<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $adPosition->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">位置名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $adPosition->name }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">建议宽度<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="width" value="{{ $adPosition->width }}" lay-verify="required" autocomplete="off" class="layui-input label-input width-per-50">
                <span class="label">px</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">建议高度<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="height" value="{{ $adPosition->height }}" lay-verify="required" autocomplete="off" class="layui-input label-input width-per-50">
                <span class="label">px</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" value="{{ $adPosition->sort }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="ad_positions_info">更新</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form'], function () {
        var form = layui.form;
        form.render();

        form.on('submit(ad_positions_info)', function (data) {
            Save('{{ $adPosition->id }}', data.field);
        });
    })
</script>