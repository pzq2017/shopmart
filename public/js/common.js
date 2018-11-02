var Qk = Qk || {};
var loading = 0;

var layer = layui.use('layer', function () {
    return layui.layer;
});

Qk.open = function (optioins) {
    var opts = {};
    opts = $.extend(opts, {offset: '100px'}, optioins);
    return layer.open(opts);
}

Qk.confirm = function (options) {
    var opts = {};
    opts = $.extend(opts, {title: '系统提示', offset: '150px'}, options);
    return layer.confirm(opts.content, {icon: 3, title: opts.title, offset: opts.offset}, options.yes, options.cancel);
}

Qk.msg = function (msg, options, func) {
    if (typeof(options) !== 'function') {
        var opts = {};
        opts = $.extend(opts, {time: 2000, shade: [0.4, '#000000']}, options);
        return layer.msg(msg, opts, func);
    } else {
        return layer.msg(msg, options);
    }
}

Qk.tips = function (content, selector, options) {
    var opts = {};
    opts = $.extend(opts, {tips: 1, time: 2000, maxWidth: 260}, options);
    return layer.tips(content, selector, opts);
}

Qk.loading = function () {
    return layer.load(2);
}

Qk.close = function (index) {
    loading = 0;
    return layer.close(index);
}

Qk.ajaxRequest = function (url, params, type, successCallback, failCallback, dataType="json") {
    if (loading < 1) loading = Qk.msg('加载中...', {icon: 16, time: 60000});
    $.ajax({
        type: type,
        url: url,
        data: params,
        dataType: dataType,
        headers: {
            'X-CSRF-TOKEN': baseParams.csrf_token
        },
        success: function (data) {
            if (loading > 0) Qk.close(loading);
            if (typeof(data) === 'string' && dataType == 'json') {
                data = JSON.stringify(data);
            }
            var is_no_login = false;
            if (dataType == 'json' && data.status == 'no_login') {
                is_no_login = true;
            } else if (data == '{"status":"no_login"}') {
                is_no_login = true;
            }
            if (is_no_login) {
                this.msg('登录信息已失效，请重新登录后再操作.', {icon: 2}, function () {
                    location.href = '/admin/login';
                })
            } else {
                successCallback(data);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            if (loading > 0) Qk.close(loading);
            if (typeof(XMLHttpRequest) === 'string') {
                XMLHttpRequest = JSON.stringify(XMLHttpRequest);
            }
            if (XMLHttpRequest.responseJSON) {
                if (XMLHttpRequest.responseJSON.errors) {
                    failCallback(XMLHttpRequest.responseJSON.errors);
                } else if(XMLHttpRequest.responseJSON.message) {
                    failCallback(XMLHttpRequest.responseJSON.message);
                } else if(XMLHttpRequest.responseJSON.info) {
                    failCallback(XMLHttpRequest.responseJSON.info);
                }
            } else {
                Qk.msg('errors:'+textStatus, {icon: 2});
            }
        }
    })
}

Qk.loadPage = function (url, params, successCallback, failCallback) {
    this.ajaxRequest(url, params, 'GET', successCallback, failCallback, 'html')
};

Qk.getParams = function (obj) {
    var params = {}, chk = {}, s;
    $(obj).each(function () {
        var inpType = $(this)[0].type, types = ['hidden', 'number', 'tel', 'password', 'text', 'textarea', 'select', 'select-one'];
        if (types.indexOf(inpType) > -1) {
            params[$(this).attr('name')] = $.trim($(this).val());
        } else if (inpType == 'radio') {
            if ($(this).attr('name')) {
                params[$(this).attr('name')] = $('input[name='+$(this).attr('name')+']:checked').val();
            }
        } else if (inpType == 'checkbox') {
            if ($(this).attr('name') && !chk[$(this).attr('name')]) {
                s = [];
                chk[$(this).attr('name')] = 1;
                $('input['+$(this).attr('name')+']:checked').each(function () {
                    s.push($(this).val());
                })
                params[$(this).attr('name')] = s.join(',');
            }
        }
    })
    chk = null, s = null;
    return params;
}

Qk.getRealRoutePath = function (routeUrl, params) {
    var append = [];
    for (var param in params) {
        var search_param = '{' + param + '}';
        if (routeUrl.indexOf(search_param) > 0) {
            routeUrl = routeUrl.replace(search_param, params[param]);
        } else {
            append.push(param + '=' + params[param]);
        }
    }
    if (append.length == 0) {
        return routeUrl;
    }
    if (routeUrl.indexOf('?') > 0) {
        routeUrl += '&';
    } else {
        routeUrl += '?';
    }
    routeUrl += append.join('&');
    return routeUrl;
}

Qk.templateData = function (template, data) {
    var pattern = /{(.*?)}/g
    while(result = pattern.exec(template)) {
        if (result[1]) {
            if (typeof data[result[1]] !== 'undefined' && data[result[1]] != null) {
                template = template.replace(result[0], data[result[1]]);
            } else {
                template = template.replace(result[0], '');
            }
        }
    }
    return template;
}

Qk.pageHeight = function () {
    return document.documentElement.clientHeight || document.body.clientHeight;
}

Qk.pageWidth = function () {
    return document.documentElement.clientWidth || document.body.clientWidth;
}

Qk.defaultPageSize = 25;
Qk.defaultPageSizeOptions = [25, 50, 100];
Qk.maxUploadSize = 20 * 1024;