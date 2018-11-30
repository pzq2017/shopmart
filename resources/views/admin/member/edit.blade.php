<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $member->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">登录账号<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="loginAccount" value="{{ $member->loginAccount }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户昵称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="nickname" value="{{ $member->nickname }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像照片:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list {{ !empty($member->avatar) ? '' : 'hidden' }}">
                        <input type="hidden" name="avatar" value="{{ $member->avatar }}" id="avatar_value">
                        <img class="layui-upload-img" src="/file/{{ $member->avatar }}" id="avatar_preview" style="max-height: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="avatar_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名:</label>
            <div class="layui-input-inline">
                <input type="text" name="realname" value="{{ $member->realname }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别:</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="0" title="未知" {{ $member->sex == 0 ? 'checked' : '' }}>
                <input type="radio" name="sex" value="1" title="男" {{ $member->sex == 1 ? 'checked' : '' }}>
                <input type="radio" name="sex" value="2" title="女" {{ $member->sex == 2 ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">生日:</label>
            <div class="layui-input-inline">
                <input type="text" name="birthday" id="birthday" value="{{ $member->birthday }}" autocomplete="off" placeholder="yyyy-MM-dd" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="mobile" value="{{ $member->mobile }}" lay-verify="required|phone" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱地址:</label>
            <div class="layui-input-inline">
                <input type="text" name="email" value="{{ $member->email }}" lay-verify="input_email" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">QQ:</label>
            <div class="layui-input-inline">
                <input type="text" name="qq" value="{{ $member->qq }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="member_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'laydate'], function () {
        var form = layui.form, laydate = layui.laydate;
        form.render();

        laydate.render({
            elem: '#birthday',
            format: 'yyyy-MM-dd'
        })

        form.verify({
            input_email: function (value) {
                var emailVerify = form.config.verify.email;
                if (value && !emailVerify[0].test(value)) {
                    return emailVerify[1];
                }
            }
        });

        form.on('submit(member_info)', function (data) {
            Save('{{ $member->id }}', data.field);
        });
    })

    uploadFile('avatar', 'images', 'jpg|png|gif|jpeg');
</script>