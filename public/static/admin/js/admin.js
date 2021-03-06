/**
 * description：基于开源  layuimini 框架扩展，进行二次修改
 */

layui.define(["element", "jquery"], function (exports) {
    var element = layui.element,
        $ = layui.$,
        layer = layui.layer;

    // 判断是否在web容器中打开
    if (!/http(s*):\/\//.test(location.href)) {
        return layer.alert("请先将项目部署至web容器（Apache/Tomcat/Nginx/IIS/等），否则部分数据将无法显示");
    }

    admin = new function () {

        /**
         *  系统配置
         * @param name
         * @returns {{BgColorDefault: number, urlSuffixDefault: boolean}|*}
         */
        this.config = function (name) {

            var config = {
                urlHashLocation: true,   // URL地址hash定位
                urlSuffixDefault: true, // URL后缀
                BgColorDefault: 0       // 默认皮肤（0开始）
            };

            if (name == undefined) {
                return config;
            } else {
                return config[name];
            }
        };

        /**
         * 初始化
         * @param url
         */
        this.init = function (url) {
            var loading = layer.load(0, { shade: false, time: 2 * 1000 });
            this.initBgColor();
            this.initDevice();

            this.initTab();
            element.init();
            this.initHome(url);
            layer.close(loading);
        };

        /**
         * 初始化设备端
         */
        this.initDevice = function () {
            if (admin.checkMobile()) {
                $('.admin-tool i').attr('data-side-fold', 0);
                $('.admin-tool i').attr('class', 'fa fa-indent');
                $('.layui-layout-body').attr('class', 'layui-layout-body admin-mini');
            }
        };

        /**
                 * 点击滚动
                 * @param direction
                 */
        this.rollClick = function (direction) {
            var $tabTitle = $('.admin-tab  .layui-tab-title');
            var left = $tabTitle.scrollLeft();
            if ('left' === direction) {
                $tabTitle.animate({
                    scrollLeft: left - 450
                }, 200);
            } else {
                $tabTitle.animate({
                    scrollLeft: left + 450
                }, 200);
            }
        }

        /**
         * 初始化清理缓存
         * @param data
         */
        this.initClear = function (data) {
            $('.admin-clear').attr('data-href', data.clearUrl);
        };

        /**
         * 初始化首页信息
         * @param data
         */
        this.initHome = function (href) {
            sessionStorage.setItem('adminHomeHref', href);
            $('#adminHomeTabId').html('<i class="layui-icon layui-icon-home"></i> ');
            $('#adminHomeTabId').attr('lay-id', href);
            $('#adminHomeTabIframe').html('<iframe  class="admin-home-iframe" frameborder="0"  src="' + href + '"></iframe>');
        };
        /**
         * 初始化设备端
         */
        this.renderDevice = function () {
            if (admin.checkMobile()) {
                $('.admin-tool i').attr('data-side-fold', 1);
                $('.admin-tool i').attr('class', 'fa fa-outdent');
                $('.layui-layout-body').removeClass('admin-mini');
                $('.layui-layout-body').addClass('admin-all');
            }
        };

        /**
         * 初始化背景色
         */
        this.initBgColor = function () {
            var bgcolorId = sessionStorage.getItem('adminBgcolorId');
            if (bgcolorId == null || bgcolorId == undefined || bgcolorId == '') {
                bgcolorId = admin.config('BgColorDefault');
            }
            var bgcolorData = admin.bgColorConfig(bgcolorId);
            var styleHtml = '.layui-layout-admin .layui-header{background-color:' + bgcolorData.headerRight + '!important;}\n' +
                '.layui-header>ul>.layui-nav-item.layui-this,.admin-tool i:hover{background-color:' + bgcolorData.headerRightThis + '!important;}\n' +
                '.layui-layout-admin .layui-logo {background-color:' + bgcolorData.headerLogo + '!important;}\n' +
                '.layui-side.layui-bg-black,.layui-side.layui-bg-black>.layui-left-menu>ul {background-color:' + bgcolorData.menuLeft + '!important;}\n' +
                '.layui-left-menu .layui-nav .layui-nav-child a:hover:not(.layui-this) {background-color:' + bgcolorData.menuLeftHover + ';}\n' +
                '.layui-layout-admin .layui-nav-tree .layui-this, .layui-layout-admin .layui-nav-tree .layui-this>a, .layui-layout-admin .layui-nav-tree .layui-nav-child dd.layui-this, .layui-layout-admin .layui-nav-tree .layui-nav-child dd.layui-this a {\n' +
                '    background-color: ' + bgcolorData.menuLeftThis + ' !important;\n' +
                '}';
            $('#admin-bg-color').html(styleHtml);
        };



        /**
         * 初始化选项卡
         */
        this.initTab = function () {
            var locationHref = window.location.href;
            var urlArr = locationHref.split("#");
            if (urlArr.length >= 2) {
                var href = urlArr.pop();

                // 判断链接是否有效
                // var checkUrl = admin.checkUrl(href);
                // if (checkUrl != true) {
                //     return admin.msg_error(checkUrl);
                // }

                // 判断tab是否存在
                var checkTab = admin.checkTab(href);
                if (!checkTab) {
                    var title = href,
                        tabId = href;
                    $("[data-tab]").each(function () {
                        var checkHref = $(this).attr("data-tab");

                        // 判断是否带参数了
                        if (admin.config('urlSuffixDefault')) {
                            if (href.indexOf("mpi=") > -1) {
                                var menuParameId = $(this).attr('data-tab-mpi');
                                if (checkHref.indexOf("?") > -1) {
                                    checkHref = checkHref + '&mpi=' + menuParameId;
                                } else {
                                    checkHref = checkHref + '?mpi=' + menuParameId;
                                }
                            }
                        }

                        if (checkHref == tabId) {
                            title = $(this).html();
                            title = title.replace('style="display: none;"', '');

                            // 自动展开菜单栏
                            var addMenuClass = function ($element, type) {
                                if (type == 1) {
                                    $element.addClass('layui-this');
                                    if ($element.attr('class') != 'layui-nav-item layui-this') {
                                        addMenuClass($element.parent().parent(), 2);
                                    } else {
                                        var moduleId = $element.parent().attr('id');
                                        $(".layui-header-menu li").attr('class', 'layui-nav-item');
                                        $("#" + moduleId + "HeaderId").addClass("layui-this");
                                        $(".layui-left-nav-tree").attr('class', 'layui-nav layui-nav-tree layui-hide');
                                        $("#" + moduleId).attr('class', 'layui-nav layui-nav-tree layui-this');
                                    }
                                } else {
                                    $element.addClass('layui-nav-itemed');
                                    if ($element.attr('class') != 'layui-nav-item layui-nav-itemed') {
                                        addMenuClass($element.parent().parent(), 2);
                                    } else {
                                        var moduleId = $element.parent().attr('id');
                                        $(".layui-header-menu li").attr('class', 'layui-nav-item');
                                        $("#" + moduleId + "HeaderId").addClass("layui-this");
                                        $(".layui-left-nav-tree").attr('class', 'layui-nav layui-nav-tree layui-hide');
                                        $("#" + moduleId).attr('class', 'layui-nav layui-nav-tree layui-this');
                                    }
                                }
                            };
                            addMenuClass($(this).parent(), 1);
                        }
                    });
                    var adminHomeTab = $('#adminHomeTab').attr('lay-id'),
                        adminHomeHref = sessionStorage.getItem('adminHomeHref');

                    // 非菜单打开的tab窗口
                    if (href == title) {
                        var adminTabInfo = JSON.parse(sessionStorage.getItem("adminTabInfo"));
                        if (adminTabInfo != null) {
                            var check = adminTabInfo[tabId];
                            if (check != undefined || check != null) {
                                title = check['title'];
                            }
                        }
                    }

                    if (adminHomeTab != href && adminHomeHref != href) {
                        admin.addTab(tabId, href, title, true);
                        admin.changeTab(tabId);
                    }
                }
            }
            if (admin.config('urlHashLocation')) {
                admin.hashTab();
            }
        };

        /**
         * 配色方案配置项(默认选中第一个方案)
         * @param bgcolorId
         */
        this.bgColorConfig = function (bgcolorId) {
            var bgColorConfig = [
                {
                    headerRight: '#1aa094',
                    headerRightThis: '#197971',
                    headerLogo: '#243346',
                    menuLeft: '#2f4056',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#23262e',
                    headerRightThis: '#0c0c0c',
                    headerLogo: '#0c0c0c',
                    menuLeft: '#23262e',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#ffa4d1',
                    headerRightThis: '#bf7b9d',
                    headerLogo: '#e694bd',
                    menuLeft: '#1f1f1f',
                    menuLeftThis: '#ffa4d1',
                    menuLeftHover: '#1f1f1f',
                },
                {
                    headerRight: '#1aa094',
                    headerRightThis: '#197971',
                    headerLogo: '#0c0c0c',
                    menuLeft: '#23262e',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#1e9fff',
                    headerRightThis: '#0069b7',
                    headerLogo: '#0c0c0c',
                    menuLeft: '#1f1f1f',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },

                {
                    headerRight: '#ffb800',
                    headerRightThis: '#d09600',
                    headerLogo: '#243346',
                    menuLeft: '#2f4056',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#e82121',
                    headerRightThis: '#ae1919',
                    headerLogo: '#0c0c0c',
                    menuLeft: '#1f1f1f',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#963885',
                    headerRightThis: '#772c6a',
                    headerLogo: '#243346',
                    menuLeft: '#2f4056',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#1e9fff',
                    headerRightThis: '#0069b7',
                    headerLogo: '#0069b7',
                    menuLeft: '#1f1f1f',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#ffb800',
                    headerRightThis: '#d09600',
                    headerLogo: '#d09600',
                    menuLeft: '#2f4056',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#e82121',
                    headerRightThis: '#ae1919',
                    headerLogo: '#d91f1f',
                    menuLeft: '#1f1f1f',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                },
                {
                    headerRight: '#963885',
                    headerRightThis: '#772c6a',
                    headerLogo: '#772c6a',
                    menuLeft: '#2f4056',
                    menuLeftThis: '#1aa094',
                    menuLeftHover: '#3b3f4b',
                }
            ];

            if (bgcolorId == undefined) {
                return bgColorConfig;
            } else {
                return bgColorConfig[bgcolorId];
            }
        };

        /**
         * 构建背景颜色选择
         * @returns {string}
         */
        this.buildBgColorHtml = function () {
            var html = '';
            var bgcolorId = sessionStorage.getItem('adminBgcolorId');
            if (bgcolorId == null || bgcolorId == undefined || bgcolorId == '') {
                bgcolorId = 0;
            }
            var bgColorConfig = admin.bgColorConfig();
            $.each(bgColorConfig, function (key, val) {
                if (key == bgcolorId) {
                    html += '<li class="layui-this" data-select-bgcolor="' + key + '">\n';
                } else {
                    html += '<li  data-select-bgcolor="' + key + '">\n';
                }
                html += '<a href="javascript:;" data-skin="skin-blue" style="" class="clearfix full-opacity-hover">\n' +
                    '<div><span style="display:block; width: 20%; float: left; height: 12px; background: ' + val.headerLogo + ';"></span><span style="display:block; width: 80%; float: left; height: 12px; background: ' + val.headerRight + ';"></span></div>\n' +
                    '<div><span style="display:block; width: 20%; float: left; height: 40px; background: ' + val.menuLeft + ';"></span><span style="display:block; width: 80%; float: left; height: 40px; background: #f4f5f7;"></span></div>\n' +
                    '</a>\n' +
                    '</li>';
            });
            return html;
        };

        /**
         * 判断窗口是否已打开
         * @param tabId
         **/
        this.checkTab = function (tabId, isIframe) {
            // 判断选项卡上是否有
            var checkTab = false;
            if (isIframe == undefined || isIframe == false) {
                $(".layui-tab-title li").each(function () {
                    checkTabId = $(this).attr('lay-id');
                    if (checkTabId != null && checkTabId == tabId) {
                        checkTab = true;
                    }
                });
            } else {
                parent.layui.$(".layui-tab-title li").each(function () {
                    checkTabId = $(this).attr('lay-id');
                    if (checkTabId != null && checkTabId == tabId) {
                        checkTab = true;
                    }
                });
            }
            if (checkTab == false) {
                return false;
            }

            // 判断sessionStorage是否有
            var adminTabInfo = JSON.parse(sessionStorage.getItem("adminTabInfo"));
            if (adminTabInfo == null) {
                adminTabInfo = {};
            }
            var check = adminTabInfo[tabId];
            if (check == undefined || check == null) {
                return false;
            }
            return true;
        };

        /**
         * 打开新窗口
         * @param tabId
         * @param href
         * @param title
         */
        this.addTab = function (tabId, href, title, addSession) {
            if (addSession == undefined || addSession == true) {
                var adminTabInfo = JSON.parse(sessionStorage.getItem("adminTabInfo"));
                if (adminTabInfo == null) {
                    adminTabInfo = {};
                }
                adminTabInfo[tabId] = { href: href, title: title }
                sessionStorage.setItem("adminTabInfo", JSON.stringify(adminTabInfo));
            }
            element.tabAdd('adminTab', {
                title: title + '<i data-tab-close="" class="layui-icon layui-unselect layui-tab-close">ဆ</i>' //用于演示
                , content: '<iframe  class="admin-home-iframe" frameborder="0"  src="' + href + '"></iframe>'
                , id: tabId
            });
            // element.tabAdd('adminTab', {
            //     title: '<span class="admin-tab-active"></span><span>' + title + '</span><i class="layui-icon layui-unselect layui-tab-close">ဆ</i>' //用于演示
            //     , content: '<iframe width="100%" height="100%" frameborder="no" border="0" marginwidth="0" marginheight="0"   src="' + href + '"></iframe>'
            //     , id: tabId
            // });
            // $('.admin-menu-left').attr('admin-tab-tag', 'add');
            // sessionStorage.setItem('adminTabInfo' + tabId,title);
        };

        /**
         * 删除窗口
         * @param tabId
         */
        this.delTab = function (tabId) {
            var adminTabInfo = JSON.parse(sessionStorage.getItem("adminTabInfo"));
            if (adminTabInfo != null) {
                delete adminTabInfo[tabId];
                sessionStorage.setItem("adminTabInfo", JSON.stringify(adminTabInfo))
            }
            element.tabDelete('adminTab', tabId);
        };

        /**
         * 切换选项卡
         **/
        this.changeTab = function (tabId) {
            element.tabChange('adminTab', tabId);
        };

        /**
         * Hash地址的定位
         */
        this.hashTab = function () {
            var layId = location.hash.replace(/^#/, '');
            element.tabChange('adminTab', layId);
            element.on('tab(adminTab)', function (elem) {
                location.hash = $(this).attr('lay-id');
            });
        };

        /**
         * 判断是否为手机
         */
        this.checkMobile = function () {
            var ua = navigator.userAgent.toLocaleLowerCase();
            var pf = navigator.platform.toLocaleLowerCase();
            var isAndroid = (/android/i).test(ua) || ((/iPhone|iPod|iPad/i).test(ua) && (/linux/i).test(pf))
                || (/ucweb.*linux/i.test(ua));
            var isIOS = (/iPhone|iPod|iPad/i).test(ua) && !isAndroid;
            var isWinPhone = (/Windows Phone|ZuneWP7/i).test(ua);
            var clientWidth = document.documentElement.clientWidth;
            if (!isAndroid && !isIOS && !isWinPhone && clientWidth > 768) {
                return false;
            } else {
                return true;
            }
        };

        /**
         * 判断链接是否有效
         * @param url
         * @returns {boolean}
         */
        this.checkUrl = function (url) {
            var msg = true;
            $.ajax({
                url: url,
                type: 'get',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                async: false,
                error: function (xhr, textstatus, thrown) {
                    msg = 'Status:' + xhr.status + '，' + xhr.statusText + '，请稍后再试！';
                }
            });
            return msg;
        };

        /**
         * 成功
         * @param title
         * @returns {*}
         */
        this.msg_success = function (title) {
            return layer.msg(title, { icon: 1, shade: this.shade, scrollbar: false, time: 2000, shadeClose: true });
        };

        /**
         * 失败
         * @param title
         * @returns {*}
         */
        this.msg_error = function (title) {
            return layer.msg(title, { icon: 2, shade: this.shade, scrollbar: false, time: 3000, shadeClose: true });
        };

        /**
         * 选项卡滚动
         */
        this.tabRoll = function () {
            $(window).on("resize", function (event) {
                var topTabsBox = $("#top_tabs_box"),
                    topTabsBoxWidth = $("#top_tabs_box").width(),
                    topTabs = $("#top_tabs"),
                    topTabsWidth = $("#top_tabs").width(),
                    tabLi = topTabs.find("li.layui-this"),
                    top_tabs = document.getElementById("top_tabs"),
                    event = event || window.event;

                if (topTabsWidth > topTabsBoxWidth) {
                    if (tabLi.position().left > topTabsBoxWidth || tabLi.position().left + topTabsBoxWidth > topTabsWidth) {
                        topTabs.css("left", topTabsBoxWidth - topTabsWidth);
                    } else {
                        topTabs.css("left", -tabLi.position().left);
                    }
                    //拖动效果
                    var flag = false;
                    var cur = {
                        x: 0,
                        y: 0
                    }
                    var nx, dx, x;

                    function down(event) {
                        flag = true;
                        var touch;
                        if (event.touches) {
                            touch = event.touches[0];
                        } else {
                            touch = event;
                        }
                        cur.x = touch.clientX;
                        dx = top_tabs.offsetLeft;
                    }

                    function move(event) {
                        var self = this;
                        if (flag) {
                            window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();
                            var touch;
                            if (event.touches) {
                                touch = event.touches[0];
                            } else {
                                touch = event;
                            }
                            nx = touch.clientX - cur.x;
                            x = dx + nx;
                            if (x > 0) {
                                x = 0;
                            } else {
                                if (x < topTabsBoxWidth - topTabsWidth) {
                                    x = topTabsBoxWidth - topTabsWidth;
                                } else {
                                    x = dx + nx;
                                }
                            }
                            top_tabs.style.left = x + "px";
                            //阻止页面的滑动默认事件
                            document.addEventListener("touchmove", function () {
                                event.preventDefault();
                            }, false);
                        }
                    }

                    //鼠标释放时候的函数
                    function end() {
                        flag = false;
                    }

                    //pc端拖动效果
                    topTabs.on("mousedown", down);
                    topTabs.on("mousemove", move);
                    $(document).on("mouseup", end);
                    //移动端拖动效果
                    topTabs.on("touchstart", down);
                    topTabs.on("touchmove", move);
                    topTabs.on("touchend", end);
                } else {
                    //移除pc端拖动效果
                    topTabs.off("mousedown", down);
                    topTabs.off("mousemove", move);
                    topTabs.off("mouseup", end);
                    //移除移动端拖动效果
                    topTabs.off("touchstart", down);
                    topTabs.off("touchmove", move);
                    topTabs.off("touchend", end);
                    topTabs.removeAttr("style");
                    return false;
                }
            }).resize();
        };


    };

    /**
     * 关闭选项卡
     **/
    $('body').on('click', '[data-tab-close]', function () {
        var loading = layer.load(0, { shade: false, time: 2 * 1000 });
        $parent = $(this).parent();
        tabId = $parent.attr('lay-id');
        if (tabId != undefined || tabId != null) {
            admin.delTab(tabId);
        }
        admin.tabRoll();
        layer.close(loading);
    });
    //定义setTimeout执行方法
    var time = null;
    //双击事件
    $('body').on('dblclick', '[admin-href]', function () {
        clearTimeout(time);
        var obj = $(this);
        adminHref(obj, true);
    });
    //事件
    $('body').on('click', '[admin-href]', function () {
        var obj = $(this);
        // 取消上次延时未执行的方法
        clearTimeout(time);
        //执行延时
        time = setTimeout(function () {
            adminHref(obj, false)
            //do function在此处写单击事件要执行的代码
        }, 300);
    });


    /**
     * 打开新窗口
     */
    function adminHref(that, flag) {


        var loading = layer.load(0, { shade: false, time: 2 * 1000 });
        var tabId = that.attr('admin-href'),
            href = that.attr('admin-href'),
            title = that.html(),
            target = that.attr('target'),
            data = that.attr('admin-data');
        if (target == '2') {
            layer.close(loading);
            window.open(href, "_blank");
            return false;
        }

        title = title.replace('style="display: none;"', '');

        // 拼接参数
        if (admin.config('urlSuffixDefault')) {
            var menuParameId = that.attr('admin-menu-id');

            if (href.indexOf("?") > -1) {
                href = href + '&menu_id=' + menuParameId;
            } else {
                href = href + '?menu_id=' + menuParameId;

            }
            if (data != undefined && data != '') {
                if (data.indexOf("&") == 0) {
                    href = href + data;
                } else {
                    href = href + '&' + data;
                }
            }

        }
        tabId = href;
        // 判断链接是否有效
        // var checkUrl = admin.checkUrl(href);
        // if (checkUrl != true) {
        //     return admin.msg_error(checkUrl);
        // }

        if (tabId == null || tabId == undefined) {
            tabId = new Date().getTime();
        }
        // 判断该窗口是否已经打开过
        var checkTab = admin.checkTab(tabId);
        if (flag) {
            if (checkTab) {
                admin.delTab(tabId);
                admin.addTab(tabId, href, title, true);
            } else {
                admin.addTab(tabId, href, title, true);
            }
        } else {
            if (!checkTab) {
                admin.addTab(tabId, href, title, true);
            }
        }

        element.tabChange('adminTab', tabId);
        admin.initDevice();
        admin.tabRoll();
        layer.close(loading);
    };

    /**
     * 在iframe子菜单上打开新窗口
     */
    $('body').on('click', '[data-iframe-tab]', function () {
        var loading = parent.layer.load(0, { shade: false, time: 2 * 1000 });
        var tabId = $(this).attr('data-iframe-tab'),
            href = $(this).attr('data-iframe-tab'),
            icon = $(this).attr('data-icon'),
            title = $(this).attr('data-title'),
            target = $(this).attr('target');
        if (target == '2') {
            parent.layer.close(loading);
            window.open(href, "_blank");
            return false;
        }
        title = '<i class="' + icon + '"></i><span class="layui-left-nav"> ' + title + '</span>';
        if (tabId == null || tabId == undefined) {
            tabId = new Date().getTime();
        }
        // 判断该窗口是否已经打开过
        var checkTab = admin.checkTab(tabId, true);
        if (!checkTab) {
            var adminTabInfo = JSON.parse(sessionStorage.getItem("adminTabInfo"));
            if (adminTabInfo == null) {
                adminTabInfo = {};
            }
            adminTabInfo[tabId] = { href: href, title: title }
            sessionStorage.setItem("adminTabInfo", JSON.stringify(adminTabInfo));
            parent.layui.element.tabAdd('adminTab', {
                title: title + '<i data-tab-close="" class="layui-icon layui-unselect layui-tab-close">ဆ</i>' //用于演示
                , content: '<iframe width="100%" height="100%" frameborder="0"  src="' + href + '"></iframe>'
                , id: tabId
            });
        }
        parent.layui.element.tabChange('adminTab', tabId);
        admin.tabRoll();
        parent.layer.close(loading);
    });

    /**
     * 左侧菜单的切换
     */
    $('body').on('click', '[data-menu]', function () {
        var loading = layer.load(0, { shade: false, time: 2 * 1000 });
        $parent = $(this).parent();
        menuId = $(this).attr('data-menu');
        // header
        $(".layui-header-menu .layui-nav-item.layui-this").removeClass('layui-this');
        $(this).addClass('layui-this');
        // left
        $(".layui-left-menu .layui-nav.layui-nav-tree.layui-this").addClass('layui-hide');
        $(".layui-left-menu .layui-nav.layui-nav-tree.layui-this.layui-hide").removeClass('layui-this');
        $("#" + menuId).removeClass('layui-hide');
        $("#" + menuId).addClass('layui-this');
        layer.close(loading);
    });

    /**
     * 清理
     */
    $('body').on('click', '[data-clear]', function () {
        var loading = layer.load(0, { shade: false, time: 2 * 1000 });
        sessionStorage.clear();

        // 判断是否清理服务端
        var clearUrl = $(this).attr('data-href');
        if (clearUrl != undefined && clearUrl != '' && clearUrl != null) {
            $.getJSON(clearUrl, function (data, status) {
                layer.close(loading);
                if (data.code != 1) {
                    return admin.msg_error(data.msg);
                } else {
                    return admin.msg_success(data.msg);
                }
            }).fail(function () {
                layer.close(loading);
                return admin.msg_error('清理缓存接口有误');
            });
        } else {
            layer.close(loading);
            return admin.msg_success('清除缓存成功');
        }
    });

    /**
     * 刷新
     */
    $('body').on('click', '[data-refresh]', function () {
        $(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload();
        admin.msg_success('刷新成功');
    });

    /**
     * 选项卡操作
     */
    $('body').on('click', '[data-page-close]', function () {
        var loading = layer.load(0, { shade: false, time: 2 * 1000 });
        var closeType = $(this).attr('data-page-close');
        $(".layui-tab-title li").each(function () {
            tabId = $(this).attr('lay-id');
            var id = $(this).attr('id');
            if (id != 'adminHomeTabId') {
                var tabClass = $(this).attr('class');
                if (closeType == 'all') {
                    admin.delTab(tabId);
                } else {
                    if (tabClass != 'layui-this') {
                        admin.delTab(tabId);
                    }
                }
            }
        });
        admin.tabRoll();
        layer.close(loading);
    });

    /**
     * 菜单栏缩放
     */
    $('body').on('click', '[data-side-fold]', function () {
        var loading = layer.load(0, { shade: false, time: 2 * 1000 });
        var isShow = $(this).attr('data-side-fold');
        if (isShow == 1) { // 缩放
            $(this).attr('data-side-fold', 0);
            $('.admin-tool i').attr('class', 'fa fa-indent');
            $('.layui-layout-body').attr('class', 'layui-layout-body admin-mini');
        } else { // 正常
            $(this).attr('data-side-fold', 1);
            $('.admin-tool i').attr('class', 'fa fa-outdent');
            $('.layui-layout-body').attr('class', 'layui-layout-body admin-all');
        }
        admin.tabRoll();
        element.init();
        layer.close(loading);
    });

    /**
     * 监听提示信息
     */
    $("body").on("mouseenter", ".layui-menu-tips", function () {
        var classInfo = $(this).attr('class'),
            tips = $(this).children('span').text(),
            isShow = $('.admin-tool i').attr('data-side-fold');
        if (isShow == 0) {
            openTips = layer.tips(tips, $(this), { tips: [2, '#2f4056'], time: 30000 });
        }
    });
    $("body").on("mouseleave", ".layui-menu-tips", function () {
        var isShow = $('.admin-tool i').attr('data-side-fold');
        if (isShow == 0) {
            try {
                layer.close(openTips);
            } catch (e) {
                console.log(e.message);
            }
        }
    });

    /**
     * 弹出配色方案
     */
    $('body').on('click', '[data-bgcolor]', function () {
        var loading = layer.load(0, { shade: false, time: 2 * 1000 });
        var clientHeight = (document.documentElement.clientHeight) - 95;
        var bgColorHtml = admin.buildBgColorHtml();
        var html = '<div class="admin-color">\n' +
            '<div class="color-title">\n' +
            '<span>配色方案</span>\n' +
            '</div>\n' +
            '<div class="color-content">\n' +
            '<ul>\n' + bgColorHtml + '</ul>\n' +
            '</div>\n' +
            '</div>';
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shade: 0.2,
            anim: 2,
            shadeClose: true,
            id: 'adminBgColor',
            area: ['340px', clientHeight + 'px'],
            offset: 'rb',
            content: html,
        });
        layer.close(loading);
    });

    /**
     * 选择配色方案
     */
    $('body').on('click', '[data-select-bgcolor]', function () {
        var bgcolorId = $(this).attr('data-select-bgcolor');
        $('.admin-color .color-content ul .layui-this').attr('class', '');
        $(this).attr('class', 'layui-this');
        sessionStorage.setItem('adminBgcolorId', bgcolorId);
        admin.initBgColor();
    });

    /**
             * 全屏
             */
    $('body').on('click', '[data-check-screen]', function () {
        var check = $(this).attr('data-check-screen');
        if (check == 'full') {
            admin.fullScreen();
            $(this).attr('data-check-screen', 'exit');
            $(this).html('<i class="fa fa-compress"></i>');
        } else {
            admin.exitFullScreen();
            $(this).attr('data-check-screen', 'full');
            $(this).html('<i class="fa fa-arrows-alt"></i>');
        }
    });

    /**
     * 点击遮罩层
     */
    $('body').on('click', '.admin-make', function () {
        admin.renderDevice();
    });

    /**
     * 监听滚动
     */

    $(".admin-tab-roll-left").click(function () {
        admin.rollClick("left");
    });
    $(".admin-tab-roll-right").click(function () {
        admin.rollClick("right");
    });




    exports("admin", admin);
});
