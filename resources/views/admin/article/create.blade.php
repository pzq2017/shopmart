<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <label class="layui-form-label">类别<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <select name="catId" lay-filter="article_category" lay-verify="required">
                    <option value="">请选择类别</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" title="{{ $category->type }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" autocomplete="off" class="layui-input form-title width-per-60">
            </div>
        </div>
        <div class="layui-form-item list-picture-display hidden">
            <label class="layui-form-label">图片<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list hidden">
                        <input type="hidden" name="image_path" id="image_value">
                        <img class="layui-upload-img" src="" id="image_preview" style="width: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="image_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item list-text-display hidden">
            <label class="layui-form-label">简述:</label>
            <div class="layui-input-block">
                <textarea name="desc" class="layui-input width-per-60" style="height: 100px;"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">内容<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <textarea name="text" class="layui-input"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">作者:</label>
            <div class="layui-input-inline">
                <input type="text" name="author" value="{{ optional(admin_auth())->loginName }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" autocomplete="off" class="layui-input width-per-50">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="article_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('select(article_category)', function (data) {
            var type = data.elem[data.elem.selectedIndex].title;
            if (type == {{ \App\Models\ArticleCategory::TYPE_TEXT_LIST }}) {
                $('.list-text-display').removeClass('hidden');
                $('.form-title').val('');
            } else if (type == {{ \App\Models\ArticleCategory::TYPE_TEXT_AND_PICTURE_LIST }}) {
                $('.list-text-display').removeClass('hidden');
                $('.list-picture-display').removeClass('hidden');
                $('.form-title').val('');
            } else {
                if (type == {{ \App\Models\ArticleCategory::TYPE_SINGLE }}) {
                    $('.form-title').val(data.elem[data.elem.selectedIndex].text);
                } else {
                    $('.form-title').val('');
                }
                $('.list-text-display').addClass('hidden');
                $('.list-picture-display').addClass('hidden');
            }
        });

        form.on('submit(article_info)', function (data) {
            Save(0, data.field);
        });
    })

    uploadFile('image', 'images', 'jpg|png|gif|jpeg');
</script>