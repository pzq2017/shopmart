<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <label class="layui-form-label">等级名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">等级图标<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list hidden">
                        <input type="hidden" name="icon" id="icon_value">
                        <img class="layui-upload-img" src="" id="icon_preview" style="max-height: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="icon_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,png</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">积分下限<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="number" name="min_score" lay-verify="required" autocomplete="off" class="layui-input width-per-50">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">积分上限<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="number" name="max_score" lay-verify="required" autocomplete="off" class="layui-input width-per-50">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="member_grade_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('submit(member_grade_info)', function (data) {
            Save(0, data.field);
        });
    })

    uploadFile('icon', 'images', 'jpg|png|jpeg');
</script>