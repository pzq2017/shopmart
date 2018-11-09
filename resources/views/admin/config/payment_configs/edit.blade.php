<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="goBack('{{ route('admin.config.payment_config.index') }}')">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $paymentConfig->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">支付名称:</label>
            <div class="layui-input-block">
                <input type="text" value="{{ $paymentConfig->name }}" disabled lay-verify="required" autocomplete="off" class="layui-input layui-disabled width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付图标<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload-list {{ $paymentConfig->icon ? '' : 'hidden' }}">
                    <input type="hidden" name="icon" id="icon_value" value="{{ $paymentConfig->icon }}" lay-verify="required">
                    <img class="layui-upload-img" src="/file/{{ $paymentConfig->icon }}" id="icon_preview" style="width: 100px;">
                </div>
                <button type="button" class="layui-btn layui-btn-danger" id="icon_upload">上传图片</button>
                <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png;</span>
            </div>
        </div>
        @if($paymentConfig->code == \App\Models\PaymentConfig::ALIPAY)
        <div class="layui-form-item">
            <label class="layui-form-label">商户号<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="partner" value="{{ isset($config['partner']) ? $config['partner'] : '' }}" lay-verify="required" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">收款支付宝账号<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="seller_email" value="{{ isset($config['seller_email']) ? $config['seller_email'] : '' }}" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付密钥<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="key" value="{{ isset($config['key']) ? $config['key'] : '' }}" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商户私钥<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="rsa_private_key_upload">上传文件</button>
                    <input type="text" name="rsa_private_key" id="rsa_private_key_value" value="{{ isset($config['rsa_private_key']) ? $config['rsa_private_key'] : '' }}" disabled lay-verify="required" class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">私钥文件格式仅支持:pem;</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付宝公钥<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="rsa_public_key_upload">上传文件</button>
                    <input type="text" name="rsa_public_key" id="rsa_public_key_value" value="{{ isset($config['rsa_public_key']) ? $config['rsa_public_key'] : '' }}" disabled lay-verify="required" class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">公钥文件格式仅支持:pem;</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">ca证书<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="cacert_upload">上传文件</button>
                    <input type="text" name="cacert" id="cacert_value" value="{{ isset($config['cacert']) ? $config['cacert'] : '' }}" disabled lay-verify="required" class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">ca证书文件格式仅支持:pem;</span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            uploadFile('rsa_private_key', 'file', 'pem');
            uploadFile('rsa_public_key', 'file', 'pem');
            uploadFile('cacert', 'file', 'pem');
        </script>
        @elseif($paymentConfig->code == \App\Models\PaymentConfig::WXPAY)
        <div class="layui-form-item">
            <label class="layui-form-label">公众号AppId<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="appid" value="{{ isset($config['appid']) ? $config['appid'] : '' }}" lay-verify="required" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公众号AppSecret<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="appsecret" value="{{ isset($config['appsecret']) ? $config['appsecret'] : '' }}" lay-verify="required" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付商户号<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="mchid" value="{{ isset($config['mchid']) ? $config['mchid'] : '' }}" lay-verify="required" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付密钥<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="key" value="{{ isset($config['key']) ? $config['key'] : '' }}" lay-verify="required" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend style="font-size: 14px;">退款、撤销订单时需要上传证书文件</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">API证书:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="apiclient_cert_upload">上传文件</button>
                    <input type="text" name="apiclient_cert" id="apiclient_cert_value" value="{{ isset($config['apiclient_cert']) ? $config['apiclient_cert'] : '' }}" disabled class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">格式仅支持:pem;</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">API密钥:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="apiclient_key_upload">上传文件</button>
                    <input type="text" name="apiclient_key" id="apiclient_key_value" value="{{ isset($config['apiclient_key']) ? $config['apiclient_key'] : '' }}" disabled class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">格式仅支持:pem;</span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            uploadFile('apiclient_cert', 'file', 'pem');
            uploadFile('apiclient_key', 'file', 'pem');
        </script>
        @elseif($paymentConfig->code == \App\Models\PaymentConfig::UPACP)
        <div class="layui-form-item">
            <label class="layui-form-label">生产环境<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="radio" name="environment" value="0" title="测试环境" {{ (isset($configs['environment']) && $configs['environment'] == 0 || !isset($configs['environment'])) ? 'checked' : '' }}>
                <input type="radio" name="environment" value="1" title="正式环境" {{ (isset($configs['environment']) && $configs['environment'] == 1) ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">商户号<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="partner" value="{{ isset($config['partner']) ? $config['partner'] : '' }}" lay-verify="required" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">签名证书<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="sign_cert_upload">上传文件</button>
                    <input type="text" name="sign_cert" id="sign_cert_value" value="{{ isset($config['sign_cert']) ? $config['sign_cert'] : '' }}" disabled class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">格式仅支持:pfx;</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">签名证书密码<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="sign_pwd" value="{{ isset($config['sign_pwd']) ? $config['sign_pwd'] : '' }}" lay-verify="required" autocomplete="off" class="layui-input width-per-30">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">验签证书<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="verify_cert_upload">上传文件</button>
                    <input type="text" name="verify_cert" id="verify_cert_value" value="{{ isset($config['verify_cert']) ? $config['verify_cert'] : '' }}" disabled class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">格式仅支持:cer;</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码加密证书<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-danger" id="encrypt_cert_upload">上传文件</button>
                    <input type="text" name="encrypt_cert" id="encrypt_cert_value" value="{{ isset($config['encrypt_cert']) ? $config['encrypt_cert'] : '' }}" disabled class="layui-input label-input width-per-30 layui-disabled" style="margin-left:0px;">
                    <span class="upload_tips">格式仅支持:cer;</span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            uploadFile('sign_cert', 'file', 'pfx');
            uploadFile('verify_cert', 'file', 'cer');
            uploadFile('encrypt_cert', 'file', 'cer');
        </script>
        @endif
        <div class="layui-form-item">
            <label class="layui-form-label">描述:</label>
            <div class="layui-input-block">
                <textarea name="desc" class="layui-input width-per-30" style="height: 70px;">{{ $paymentConfig->desc }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" value="{{ $paymentConfig->sort }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="payment_config_info">更新</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form'], function () {
        var form = layui.form;
        form.render();

        form.on('submit(payment_config_info)', function (data) {
            Save('{{ $paymentConfig->id }}', data.field);
        });
    })

    uploadFile('icon', 'images', 'jpg|jpeg|gif|png');
</script>