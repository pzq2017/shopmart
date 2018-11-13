<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card" id="content_box">
                    <div class="layui-tab">
                        <ul class="layui-tab-title">
                            <li class="layui-this">基础设置</li>
                            <li>服务器设置</li>
                            <li>运营设置</li>
                            <li>图片设置</li>
                            <li>SEO设置</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <form class="layui-form" onsubmit="return false;">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">平台名称:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="platformName" lay-verify="required" value="{{ isset($configs['platformName']) ? $configs['platformName'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">商品审核:</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="goods_verify" value="1" title="开启" {{ (isset($configs['goods_verify']) && $configs['goods_verify'] == 1 || !isset($configs['goods_verify'])) ? 'checked' : '' }}>
                                            <input type="radio" name="goods_verify" value="0" title="关闭" {{ (isset($configs['goods_verify']) && $configs['goods_verify'] == 0) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">底部设置:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="platformFooterText" lay-verify="required" value="{{ isset($configs['platformFooterText']) ? $configs['platformFooterText'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">访问统计js:</label>
                                        <div class="layui-input-block">
                                            <textarea name="visitStatistics" autocomplete="off" class="layui-input width-per-50" style="height: 80px;">{{ isset($configs['visitStatistics']) ? $configs['visitStatistics'] : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">客服QQ:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="serviceQQ" value="{{ isset($configs['serviceQQ']) ? $configs['serviceQQ'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">联系电话:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="serviceTel" value="{{ isset($configs['serviceTel']) ? $configs['serviceTel'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">联系邮箱:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="serviceEmail" value="{{ isset($configs['serviceEmail']) ? $configs['serviceEmail'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">账号禁用关键字:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="registerLimitWords" value="{{ isset($configs['registerLimitWords']) ? $configs['registerLimitWords'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit="" lay-filter="base_info">保存</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="layui-tab-item">
                                <form class="layui-form" onsubmit="return false;">
                                    <fieldset class="layui-elem-field layui-field-title">
                                        <legend>邮件服务器设置</legend>
                                    </fieldset>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">SMTP服务器:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mailSmtp" lay-verify="required" value="{{ isset($configs['mailSmtp']) ? $configs['mailSmtp'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">SMTP端口:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mailPort" lay-verify="required" value="{{ isset($configs['mailPort']) ? $configs['mailPort'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">发件人邮箱:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mailAddress" lay-verify="required" value="{{ isset($configs['mailAddress']) ? $configs['mailAddress'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">发件人名称:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mailSendTitle" lay-verify="required" value="{{ isset($configs['mailSendTitle']) ? $configs['mailSendTitle'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">登录账号:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="mailUsername" lay-verify="required" value="{{ isset($configs['mailUsername']) ? $configs['mailUsername'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">登录密码:</label>
                                        <div class="layui-input-block">
                                            <input type="password" name="mailPassword" lay-verify="required" value="{{ isset($configs['mailPassword']) ? $configs['mailPassword'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <fieldset class="layui-elem-field layui-field-title">
                                        <legend>短信服务器设置</legend>
                                    </fieldset>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">手机验证:</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="smsOpen" value="1" title="开启" {{ (isset($configs['smsOpen']) && $configs['smsOpen'] == 1 || !isset($configs['smsOpen'])) ? 'checked' : '' }}>
                                            <input type="radio" name="smsOpen" value="0" title="关闭" {{ (isset($configs['smsOpen']) && $configs['smsOpen'] == 0) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">短信账号:</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="smsKey" lay-verify="required" value="{{ isset($configs['smsKey']) ? $configs['smsKey'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">短信密码:</label>
                                        <div class="layui-input-block">
                                            <input type="password" name="smsPass" lay-verify="required" value="{{ isset($configs['smsPass']) ? $configs['smsPass'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">号码每日发送次数:</label>
                                        <div class="layui-input-block">
                                            <input type="number" name="smsDayLimit" value="{{ isset($configs['smsDayLimit']) ? $configs['smsDayLimit'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">开启短信发送验证码:</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="smsVerify" value="1" title="开启" {{ (isset($configs['smsVerify']) && $configs['smsVerify'] == 1 || !isset($configs['smsVerify'])) ? 'checked' : '' }}>
                                            <input type="radio" name="smsVerify" value="0" title="关闭" {{ (isset($configs['smsVerify']) && $configs['smsVerify'] == 0) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit="" lay-filter="server_info">保存</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="layui-tab-item">
                                <form class="layui-form" onsubmit="return false;">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">积分支付:</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="openScorePay" value="1" title="开启" {{ (isset($configs['openScorePay']) && $configs['openScorePay'] == 1 || !isset($configs['openScorePay'])) ? 'checked' : '' }}>
                                            <input type="radio" name="openScorePay" value="0" title="关闭" {{ (isset($configs['openScorePay']) && $configs['openScorePay'] == 0) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">下单获积分:</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="openOrderScore" value="1" title="开启" {{ (isset($configs['openOrderScore']) && $configs['openOrderScore'] == 1 || !isset($configs['openOrderScore'])) ? 'checked' : '' }}>
                                            <input type="radio" name="openOrderScore" value="0" title="关闭" {{ (isset($configs['openOrderScore']) && $configs['openOrderScore'] == 0) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">评价获积分:</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="openAppraiseScore" value="1" title="开启" {{ (isset($configs['openAppraiseScore']) && $configs['openAppraiseScore'] == 1 || !isset($configs['openAppraiseScore'])) ? 'checked' : '' }}>
                                            <input type="radio" name="openAppraiseScore" value="0" title="关闭" {{ (isset($configs['openAppraiseScore']) && $configs['openAppraiseScore'] == 0) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">订单失效时间:</label>
                                        <div class="layui-input-block">
                                            <span class="label">下单后</span>
                                            <input type="number" name="autoCancelNoPayDays" value="{{ isset($configs['autoCancelNoPayDays']) ? $configs['autoCancelNoPayDays'] : '' }}" autocomplete="off" class="layui-input label-input width-per-20">
                                            <span class="label">小时</span>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">自动发货期限:</label>
                                        <div class="layui-input-block">
                                            <span class="label">发货后</span>
                                            <input type="number" name="autoReceiveDays" value="{{ isset($configs['autoReceiveDays']) ? $configs['autoReceiveDays'] : '' }}" autocomplete="off" class="layui-input label-input width-per-20">
                                            <span class="label">天自动收货</span>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">自动评价期限:</label>
                                        <div class="layui-input-block">
                                            <span class="label">确认收货后</span>
                                            <input type="number" name="autoAppraiseDays" value="{{ isset($configs['autoAppraiseDays']) ? $configs['autoAppraiseDays'] : '' }}" autocomplete="off" class="layui-input label-input width-per-20">
                                            <span class="label">天自动好评</span>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit="" lay-filter="operate_info">保存</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="layui-tab-item">
                                <form class="layui-form" onsubmit="return false;">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">平台Logo:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-upload">
                                            <div class="layui-upload-list">
                                                <input type="hidden" name="platformLogo" value="{{ isset($configs['platformLogo']) ? $configs['platformLogo'] : '' }}" id="platform_logo_value">
                                                @if(isset($configs['platformLogo']) && !empty($configs['platformLogo']))
                                                    <img class="layui-upload-img" src="/file/{{ $configs['platformLogo'] }}" id="platform_logo_preview" style="width: 100px;">
                                                @else
                                                    <img class="layui-upload-img" src="/imgs/default_headpic.png" id="platform_logo_preview" style="width: 100px;">
                                                @endif
                                            </div>
                                            <button type="button" class="layui-btn layui-btn-danger" id="platform_logo_upload">上传图片</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">默认店铺头像:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-upload">
                                            <div class="layui-upload-list">
                                                <input type="hidden" name="shopLogo" value="{{ isset($configs['shopLogo']) ? $configs['shopLogo'] : '' }}" id="shop_logo_value">
                                                @if(isset($configs['shopLogo']) && !empty($configs['shopLogo']))
                                                    <img class="layui-upload-img" src="/file/{{ $configs['shopLogo'] }}" id="shop_logo_preview" style="width: 100px;">
                                                @else
                                                    <img class="layui-upload-img" src="/imgs/default_headpic.png" id="shop_logo_preview" style="width: 100px;">
                                                @endif
                                            </div>
                                            <button type="button" class="layui-btn layui-btn-danger" id="shop_logo_upload">上传图片</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">默认会员头像:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-upload">
                                            <div class="layui-upload-list">
                                                <input type="hidden" name="userLogo" value="{{ isset($configs['userLogo']) ? $configs['userLogo'] : '' }}" id="user_logo_value">
                                                @if(isset($configs['userLogo']) && !empty($configs['userLogo']))
                                                    <img class="layui-upload-img" src="/file/{{ $configs['userLogo'] }}" id="user_logo_preview" style="width: 100px;">
                                                @else
                                                    <img class="layui-upload-img" src="/imgs/default_headpic.png" id="user_logo_preview" style="width: 100px;">
                                                @endif
                                            </div>
                                            <button type="button" class="layui-btn layui-btn-danger" id="user_logo_upload">上传图片</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">默认商品图片:</label>
                                    <div class="layui-input-block">
                                        <div class="layui-upload">
                                            <div class="layui-upload-list">
                                                <input type="hidden" name="goodsLogo" value="{{ isset($configs['goodsLogo']) ? $configs['goodsLogo'] : '' }}" id="goods_logo_value">
                                                @if(isset($configs['goodsLogo']) && !empty($configs['goodsLogo']))
                                                    <img class="layui-upload-img" src="/file/{{ $configs['goodsLogo'] }}" id="goods_logo_preview" style="width: 100px;">
                                                @else
                                                    <img class="layui-upload-img" src="/imgs/default_headpic.png" id="goods_logo_preview" style="width: 100px;">
                                                @endif
                                            </div>
                                            <button type="button" class="layui-btn layui-btn-danger" id="goods_logo_upload">上传图片</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn" lay-submit="" lay-filter="default_logo_info">保存</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="layui-tab-item">
                                <form class="layui-form" onsubmit="return false;">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">平台关键词:</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="metaKeywords" value="{{ isset($configs['metaKeywords']) ? $configs['metaKeywords'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">平台描述:</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="metaDescription" value="{{ isset($configs['metaDescription']) ? $configs['metaDescription'] : '' }}" autocomplete="off" class="layui-input width-per-50">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn" lay-submit="" lay-filter="seo_info">保存</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function Save(form_datas) {
        Common.ajaxRequest('{{ route('admin.config.platform.save') }}', form_datas, 'POST', function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    goBack('{{ route('admin.config.platform.index') }}');
                });
            } else {
                Common.msg(data.info, {icon: 2});
            }
        }, function (errors) {
            alertErrors(errors);
        });
    }

    uploadFile('platform_logo', 'images', 'jpg|png|jpeg|gif');
    uploadFile('shop_logo', 'images', 'jpg|png|jpeg|gif');
    uploadFile('user_logo', 'images', 'jpg|png|jpeg|gif');
    uploadFile('goods_logo', 'images', 'jpg|png|jpeg|gif');

    layui.use('form', function () {
        layui.form.render();

        layui.form.on('submit(base_info)', function (data) {
            Save(data.field);
        })

        layui.form.on('submit(server_info)', function (data) {
            Save(data.field);
        })

        layui.form.on('submit(operate_info)', function (data) {
            Save(data.field);
        })

        layui.form.on('submit(default_logo_info)', function (data) {
            Save(data.field);
        })

        layui.form.on('submit(seo_info)', function (data) {
            Save(data.field);
        })
    })
</script>