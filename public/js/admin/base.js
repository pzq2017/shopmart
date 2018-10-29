$(window).resize(function () {
    var h = Qk.pageHeight() - 100;
    $('.liger-tab').height(h + 26);
    $('.l-tab-content').height(h);
    $('.l-tab-content-item').height(h);
})

var mMgrs = {}, tab, currentTabId;
$(function () {
    tab = $("#tabs").ligerTab({
        height: '100%',
        changeHeightOnResize: true,
        contextmenu: false,
        showSwitch: false,
        ShowSwitchInTab: false,
        onAfterSelectTabItem: function (n) {
            var menuId = n.replace('tab-', '');
            if (!mMgrs['m' + menuId]) {
                mMgrs['m' + menuId] = true;
                initTabMenus(menuId);
            }
        }
    });
    currentTabId = tab.getSelectedTabItemID();
    mMgrs['m' + currentTabId.replace('tab-', '')] = true;
    initTabMenus(currentTabId.replace('tab-', ''));
    $('.liger-tab').height(Qk.pageHeight() - 74);
    $('.l-tab-content').height(Qk.pageHeight() - 100);
    $('.l-tab-content-item').height(Qk.pageHeight() - 100);
})

function initTabMenus(menuId) {
    Qk.ajaxRequest(window.params.subMenusUrl, {menuId: menuId}, 'GET', function (data) {
        if (data.status == 'success') {
            var subMenus = data.message, html = [];
            html.push('<div id="layout-'+menuId+'" style="width: 99.2%; margin: 0 auto; margin-top: 4px;">');
            html.push('<div position="left" id="accordion-'+menuId+'" title="管理菜单" class="accordion">');
            if (subMenus && subMenus.length > 0) {
                for (var i = 0; i < subMenus.length; i++) {
                    html.push('<div title="'+subMenus[i]['name']+'">');
                    html.push('<div style="height: 7px;"></div>');
                    if (subMenus[i]['subChildMenu']) {
                        var childMenu = subMenus[i]['subChildMenu'];
                        for (var j = 0; j < childMenu.length; j++) {
                            if (childMenu[j]['sys_leftmenu_privilige']) {
                                html.push('<a class="link" href="javascript:void(0)" url="'+childMenu[j]['sys_leftmenu_privilige']['url']+'" onclick="changeTab(this, '+menuId+')">'+childMenu[j]['name']+'</a>')
                            } else {
                                html.push('<a class="link" href="javascript:void(0)" url="" onclick="changeTab(this, '+menuId+')">'+childMenu[j]['name']+'</a>')
                            }
                        }
                    }
                    html.push('</div>');
                }
            }
            html.push('</div>');
            html.push('<div id="ltabs-'+menuId+'" position="center" class="lnavtabs">');
            html.push('<div tabid="ltab-'+menuId+'" title="我的主页" style="height: 300px;">');
            html.push('<div class="iframe" id="iframe-'+menuId+'"></div>');
            html.push('</div></div></div>');
            $('#tab-'+menuId).html(html.join(''));
            $('#layout-'+menuId).ligerLayout({
                leftWidth: 190,
                height: '100%',
                space: 0,
            });
            var height = $('.l-layout-center').height();
            $('#accordion-'+menuId).ligerAccordion({
                height: height - 24,
                speed: null,
            });
            $('#ltabs-'+menuId).ligerTab({
                height: height,
                changeHeightOnResize: true,
                showSwitchInTab: false,
                showSwitch: false,
            });
            var current_first_menu_obj = $('#accordion-'+menuId).find('.l-accordion-content').eq(0).find('a').eq(0);
            changeTab(current_first_menu_obj, menuId);
        }
    }, function (errors) {
        Qk.msg('加载失败,稍后再试.')
    })
}

function changeTab(obj, menuId) {
    var ltab = liger.get('ltabs-'+menuId), openUrl = $(obj).attr('url');
    if (!openUrl || openUrl == 'null') return Qk.msg('请到菜单权限管理里设置当前菜单的权限资源并选中是菜单权限的操作.', {icon: 2});
    ltab.setHeader('ltab-'+menuId, $(obj).text());
    var loading = Qk.loading();
    Qk.ajaxRequest(openUrl, null, 'GET', function (page) {
        Qk.close(loading);
        $('#iframe-'+menuId).html(page);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg('加载失败,稍后再试.')
    }, 'html');
}

function goBack(backurl) {
    var menuId = currentTabId.replace('tab-', '')
    if (!menuId || !backurl) return;
    var loading = Qk.loading();
    Qk.ajaxRequest(backurl, null, 'GET', function (page) {
        Qk.close(loading);
        $('#iframe-'+menuId).html(page);
    }, function (errors) {
        Qk.close(loading);
        Qk.msg('加载失败,稍后再试.')
    }, 'html');
}

function clearCache() {
    var loading = Qk.msg('正在清除缓存，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(window.params.clearCacheUrl, null, 'GET', function (data) {
        Qk.close(loading);
        if (data.status == 'success') {
            Qk.msg('缓存已成功清除', {icon: 1});
        } else {
            Qk.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Qk.close(loading);
        Qk.msg('清除缓存操作失败', {icon: 2});
    });
}

function editPwd() {
    var dialog = Qk.open({
        title: '修改密码', 
        type: 1,
        area: ['340px', '230px'],
        offset: '150px',
        content: $('#editPwdBox').html(),
        btn: ['确定', '取消'],
        yes: function (index, layero) {
            var post = Qk.getParams('.ipwd');
            var loading = Qk.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
            Qk.ajaxRequest(window.params.updPwdUrl, post, 'POST', function (data) {
                Qk.close(loading);
                if (data.status == 'success') {
                    Qk.msg('修改成功!', {icon: 1});
                    $('#editPwdForm')[0].reset();
                    Qk.close(dialog);
                } else {
                    Qk.msg(data.info, {icon: 2});
                }
            }, function (errors) {
                Qk.close(loading);
                if (typeof(errors) == 'object') {
                    for (var error in errors) {
                        Qk.msg(errors[error][0], {icon: 2});
                        return;
                    }
                } else {
                    Qk.msg(errors, {icon: 2});
                }
            });
        }
    })
}

function logout() {
    var loading = Qk.msg('正在退出账号，请稍后...', {icon: 16, time: 60000});
    Qk.ajaxRequest(window.params.logoutUrl, null, 'GET', function (data) {
        Qk.close(loading);
        if (data.status == 'success') {
            Qk.msg('账号已成功退出', {icon: 1}, function () {
                location.href = '/admin/login';
            })
        } else {
            Qk.msg(data.info, {icon: 2});
        }
    }, function (errors) {
        Qk.close(loading);
        Qk.msg('账号退出异常', {icon: 2});
    });
}

function alertErrors(errors) {
    if (typeof(errors) == 'object') {
        for (var error in errors) {
            Qk.msg(errors[error][0], {icon: 2});
            return;
        }
    } else {
        Qk.msg(errors, {icon: 2});
    }
}

function Sigupload(input, fileCat, field, supportFormat, psize, handleType) {
    var newInput = input.cloneNode(true);
        newInput.value = '';
    $(input).after(newInput);
    if (fileCat == 'picture') {
        var form = document.picture_upload_form;
    } else {
        return;
    }
    $(form).empty();

    var p_input = document.createElement("input");
        p_input.type = "hidden";
        p_input.name = "_token";
        p_input.value = window.params.csrf_token;
    form.appendChild(p_input);

    var p_input = document.createElement("input");
        p_input.type = "hidden";
        p_input.name = "field";
        p_input.value = field;
    form.appendChild(p_input);

    if (supportFormat) {
        var p_input = document.createElement("input");
            p_input.type = "hidden";
            p_input.name = "supportFormat";
            p_input.value = supportFormat;
        form.appendChild(p_input);
    }

    if (psize) {
        var p_input = document.createElement("input");
            p_input.type = "hidden";
            p_input.name = "psize";
            p_input.value = psize;
        form.appendChild(p_input);
    }

    if (handleType) {
        var p_input = document.createElement("input");
            p_input.type = "hidden";
            p_input.name = "handleType";
            p_input.value = handleType;
        form.appendChild(p_input);
    }

    form.appendChild(input);
    form.submit();
}

function SiguploadHandle(field, filename, fileCat) {
    $('#'+field).val(filename);
    if (fileCat == 'picture') {
        $('#'+field+'_preview').attr('src', '/file/temp/' + filename);
    }
}