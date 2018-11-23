<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <label class="layui-form-label">广告位置<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <select name="posid" lay-filter="ad_positions" lay-verify="required">
                    <option value="">请选择广告位置</option>
                    @foreach($ad_positions as $ad_position)
                        <option value="{{ $ad_position->id }}" title="{{ $ad_position->width }}*{{ $ad_position->height }}">{{ $ad_position->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告图片<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list hidden">
                        <input type="hidden" name="image_path" id="advert_value">
                        <img class="layui-upload-img" src="" id="advert_preview" style="width: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="advert_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png;建议上传图片大小:<font></font>px</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告链接:</label>
            <div class="layui-input-block">
                <input type="text" name="url" autocomplete="off" class="layui-input width-per-50">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开始时间<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="start_date" id="start_date" lay-verify="required" autocomplete="off" placeholder="yyyy-MM-dd" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">结束时间<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="end_date" id="end_date" lay-verify="required" autocomplete="off" placeholder="yyyy-MM-dd" class="layui-input">
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
                <button class="layui-btn" lay-submit="" lay-filter="ads_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'laydate'], function () {
        var form = layui.form, laydate = layui.laydate;
        form.render();

        laydate.render({
            elem: '#start_date',
            format: 'yyyy-MM-dd'
        })

        laydate.render({
            elem: '#end_date',
            format: 'yyyy-MM-dd'
        })

        form.on('select(ad_positions)', function (data) {
            var size = data.elem[data.elem.selectedIndex].title;
            $('.upload_tips').find('font').html(size);
            if (size) {
                uploadFile('advert', 'images', 'jpg|png|gif|jpeg');
            }
        });

        form.on('submit(ads_info)', function (data) {
            Save(0, data.field);
        });
    })

    $(document).ready(function () {
        $('#advert_upload').click(function () {
            if ($('.upload_tips').find('font').html() == '') {
                return Common.msg('请选择广告位置.', {icon: 2});
            }
        });
    })
</script>