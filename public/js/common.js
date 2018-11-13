var loading = 0;
var layer = layui.use('layer', function () {
    return layui.layer;
});
var Common = {
    open: function (options) {
        var opts = {};
        opts = $.extend(opts, {offset: '100px'}, options);
        return layer.open(opts);
    },
    confirm: function (options) {
        var opts = {};
        opts = $.extend(opts, {title: '系统提示', offset: '150px'}, options);
        return layer.confirm(opts.content, {icon: 3, title: opts.title, offset: opts.offset}, options.yes, options.cancel);
    },
    msg: function (msg, options, func) {
        if (typeof(options) !== 'function') {
            var opts = {};
            opts = $.extend(opts, {time: 2000, shade: [0.4, '#000000']}, options);
            return layer.msg(msg, opts, func);
        } else {
            return layer.msg(msg, options);
        }
    },
    tips: function (content, selector, options) {
        var opts = {};
        opts = $.extend(opts, {tips: 1, time: 2000, maxWidth: 260}, options);
        return layer.tips(content, selector, opts);
    },
    loading: function () {
        return layer.load(2);
    },
    close: function (index) {
        loading = 0;
        return layer.close(index);
    },
    ajaxRequest: function (url, params, type, successCallback, failCallback, dataType="json") {
        if (loading < 1) loading = Common.msg('加载中...', {icon: 16, time: 60000});
        $.ajax({
            type: type,
            url: url,
            data: params,
            dataType: dataType,
            headers: {
                'X-CSRF-TOKEN': baseParams.csrf_token
            },
            success: function (data) {
                if (loading > 0) Common.close(loading);
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
                if (loading > 0) Common.close(loading);
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
                    Common.msg('errors:'+textStatus, {icon: 2});
                }
            }
        })
    },
    loadPage: function (url, params, successCallback, failCallback) {
        Common.ajaxRequest(url, params, 'GET', successCallback, failCallback, 'html');
    },
    getParams: function (obj) {
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
    },
    getRealRoutePath: function (routeUrl, params) {
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
    },
    tableRender: function (options) {
        var opt = {
            elem: '#list-datas',
            where: null,
            page: true,
            limit: Const.defaultPageSize,
            limits: Const.defaultPageSizeOptions,
            parseData: function (res) {
                return {
                    "code" : 0,
                    "data" : res.message.lists,
                    "count": res.message.total,
                }
            },
            text: {
                none: '暂无数据...'
            },
        };
        layui.use('table', function () {
            layui.table.render($.extend(opt, options));
            layui.table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                } else if (event == 'del') {
                    Delete(data.id);
                }
            })
        });
    },
};

var Const = {
    defaultPageSize: 25,
    defaultPageSizeOptions: [25, 50, 100],
    maxUploadSize: 20 * 1024,
}