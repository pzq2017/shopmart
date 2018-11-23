<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <label class="layui-form-label">链接名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">链接图标<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list hidden">
                        <input type="hidden" name="image_path" id="ico_value">
                        <img class="layui-upload-img" src="" id="ico_preview" style="width: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="ico_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">链接网址:</label>
            <div class="layui-input-block">
                <input type="text" name="link" autocomplete="off" class="layui-input width-per-50">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="friend_links_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('submit(friend_links_info)', function (data) {
            Save(0, data.field);
        });
    })

    uploadFile('ico', 'images', 'jpg|jpeg|gif|png')
</script>