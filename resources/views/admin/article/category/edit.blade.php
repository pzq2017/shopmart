<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $category->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">类别名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $category->name }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分类类型<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="radio" name="type" value="{{ \App\Models\ArticleCategory::TYPE_SINGLE }}" title="单页" {{ $category->type == \App\Models\ArticleCategory::TYPE_SINGLE ? 'checked' : '' }}>
                <input type="radio" name="type" value="{{ \App\Models\ArticleCategory::TYPE_TEXT_LIST }}" title="文字列表" {{ $category->type == \App\Models\ArticleCategory::TYPE_TEXT_LIST ? 'checked' : '' }}>
                <input type="radio" name="type" value="{{ \App\Models\ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST }}" title="图文列表" {{ $category->type == \App\Models\ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" value="{{ $category->sort }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="category_info">更新</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form'], function () {
        var form = layui.form;
        form.render();

        form.on('submit(category_info)', function (data) {
            Save('{{ $category->id }}', data.field);
        });
    })
</script>