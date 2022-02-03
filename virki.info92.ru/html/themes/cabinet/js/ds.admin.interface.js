/* It's very important code! Detecting of app module name and path! */
scripts = document.getElementsByTagName('script');
thisFilePath = scripts[scripts.length - 1].src.split('?')[0];      // remove any ?query
var moduleName = thisFilePath.split('/')[4];  // remove last filename part of path
if ((typeof moduleName === 'undefined') || !(['admin', 'cabinet'].includes(moduleName))) {
    console.log('Fatal error in app module name detection!');
    throw 'Fatal error in app module name detection!';
}
delete scripts;
delete thisFilePath;

/*====================================================*/

function dsAlert(text, title, uidlg) {
    if ((typeof text !== 'undefined') && (text.length > 0)) {
        if (!uidlg) {
            alert(text);
        } else {
            var dlgExists = $('#ds-interface-alert');
            if (typeof dlgExists !== 'undefined' || dlgExists.length) {
                $('#ds-interface-alert').dialog("destroy");
            }
            //$('#ds-interface-alert').remove();
            $('<div id="ds-interface-alert" title="' + title + '">' + text + '</div>').dialog(
                {
                    closeText: '',
                    closeOnEscape: true,
                    resizable: false,
                    maxWidth: '70%',
                    minWidth: '300px',
                    width: 'auto',
                    modal: true,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("destroy");
                            return true;
                        }
                    }
                }
            )
        }
    }
}

function dsConfirm(text, title, uidlg) {
    if ((typeof text !== 'undefined') && (text.length > 0)) {
        if (!uidlg) {
            return confirm(text);
        } else {
            var dlgExists = $('#ds-interface-confirm');
            if (dlgExists) {
                $('#ds-interface-confirm').dialog("close");
            }
            $('#ds-interface-confirm').remove();
            $('<div id="ds-interface-confirm" title="' + title + '">' + text + '</div>').dialog(
                {
                    closeOnEscape: true,
                    resizable: false,
                    maxWidth: '70%',
                    minWidth: '300px',
                    width: 'auto',
                    modal: true,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                            $('#ds-interface-confirm').remove();
                            return true;
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                            $('#ds-interface-confirm').remove();
                            return false;
                        }
                    }
                }
            )
        }
    }
}

function dsProgress(text, title) {
    if ((typeof text !== 'undefined') && (text.length > 0)) {
        var dlgExists = $('#ds-interface-alert');
        if (dlgExists) {
            $('#ds-interface-alert').dialog("close");
        }
        $('#ds-interface-alert').remove();
        $('<div id="ds-interface-alert" title="' + title + '">' + text + '</div>').dialog(
            {
                //maxHeight: 50,
                minHeight: 20,
                closeOnEscape: false,
                resizable: false,
                modal: true,
                open: function (event, ui) {
                    $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
                },
                buttons: {}
            }
        );
    }
}

var prevTab = null;
var forceReload = false;

$(document).ready(function () {
    //setTimeout(updateAdminNews, 300000);
    $('body').on('click', '.close', function () {
        $('.overlay').hide();
        $('.popup').hide();
    });
//== Tabs ==============================
    try {
        var tabs = $("#admin-content").dstabs({
            cache: false,
            ajaxOptions: {cache: false},
            tabTemplate: '<li><a href="#{href}"><span>#{label}</span></a>' +
                '<a class="ds-ui-tab-button" role="tabRefresh" href="#"><i class="fa fa-refresh"></i><i class="fa fa-spinner fa-spin hidden"></i></a>' +
                '<a class="ds-ui-tab-button" role="tabClose" href="#"><i class="fa fa-close"></i></a></li>',
            add: function (event, ui) {
                $(this).dstabs('select', ui.index);
                fixTabPanelLayout(ui.panel);
//                $(ui.panel).append('<div class="row"><div class="col-sx-12"><div class="panel ds-loading"><p class="text-center"><i class="fa fa-refresh fa-spin fa-5x"></i></p></div></div></div>');
                $('#' + $(ui.tab).attr('id')).on('click', function (e) {
                    e.preventDefault();
                    return false;
                });
            },
            show: function (event, ui) {
                if (prevTab) {
                    var reloadable = $(prevTab.tab).parent().attr('reloadable');
                    if (typeof reloadable === 'undefined' || (reloadable == 'true')) {
                        prevTabContent = $(prevTab.panel);//$("#ui-tabs-" + prevTab.index);
                        //prevTabContent.html(this.options.panelOverlay);
                    }
                }
                prevTab = ui; //no var
            },
            beforeLoad: function (event, ui) {
                if (ui.tab.data("loaded") && !forceReload) {
                    var reloadable = $(ui.tab).attr('reloadable');
                    if (typeof reloadable !== 'undefined' && !(reloadable == 'true')) {
                        event.preventDefault();
                        return;
                    }
                }
                forceReload = false;
//==================== Spinner progress ====
                //$(ui.panel).addClass('overlay-wrapper');
                //$(ui.panel).append('<div class="overlay dark"><i class="fa fa-refresh fa-spin"></i></div>'); //append('<div>TEST!!!!!!!!!!!!!!!!!!!</div>');
//==========================================
                ui.jqXHR.done(function () {
                    ui.tab.data('loaded', true);
                });
                ui.jqXHR.fail(function (data) {
                    dsAlert(data.responseText);
                });
            },
            afterLoad: function (tabs, ui) {
                //  $(function () {
                //      'use strict';
                //      $('#main-view-content-section .box').boxWidget();
                //  });
                if ((typeof ui !== 'undefined') && (typeof ui.panel !== 'undefined')) {
                    initializePanelWidgets(ui.panel);
                }
            },
            afterReload: function (tabs, ui) {
                //  $(function () {
                //      'use strict';
                //      $('#main-view-content-section .box').boxWidget();
                //  });
                if ((typeof ui !== 'undefined') && (typeof ui.panel !== 'undefined')) {
//============================= Reinitialize AdminLTE and Bootstrap plugins ==========
                    reinitializePanelWidgets(ui.panel);
//====================================================================================
                }
            },
            activate: function (event, ui) {
                var url = $('#' + $(ui.newPanel.selector).attr('aria-labelledby')).attr('href');
                helpGoTo(url);
            }
        });
        //.off('click','.ds-ui-tab-button[role="tabClose"]')
        $('#admin-content-tabs').on('click', '.ds-ui-tab-button[role="tabClose"]', function (event) {
            //  if (confirm('Закрыть вкладку?')) {
            var tabBlock = $(this).parent('li');
            var indexOfTabBlock = $('#admin-content-tabs li.ui-state-default').index(tabBlock);
            tabs.dstabs('remove', indexOfTabBlock);
            //  }
        });
        //.off('click','.ds-ui-tab-button[role="tabRefresh"]')
        $('#admin-content-tabs').on('click', '.ds-ui-tab-button[role="tabRefresh"]', function (event) {
            reloadSelectedTab(event);
        });
//================
    } catch (err) {
        console.log(err);
    }
});

function helpGoTo(url, open) {
    /*
    var fullUrl = url;
    if (fullUrl.indexOf('http:') == -1) {
        fullUrl = 'http://wiki.dropshop.pro/' + url.replace(/^(?:[\/][a-z]{2}\/)|(?:^[\/])/i, '');
    }
    fullUrl = fullUrl.replace(/\/\d+$/i, '');
    $('#frame-help-url').val(fullUrl);
    var $iframe = $('#frame-help');
    if ($iframe.length) {
        if (!mainLayout.state.east.isClosed || (open === true)) {
            $iframe.attr('src', fullUrl);
            if (open === true) {
                mainLayout.open('east');
            }
        }
    }
     */
}

//@todo: сделано некрасиво, потом перенести код инициализации либо во вьюху, либо в контроллер
function initializePanelWidgets(panel) {
    $(panel).find('.box').each(function () {
        $(this).boxWidget();
    });
    $(panel).find('[data-mask]').each(function () {
        $(this).inputmask();
    });
    $(panel).find('[data-toggle="tooltip"]').each(function () {
        // The Calender
        // SLIMSCROLL FOR CHAT WIDGET
        $(this).tooltip();
    });
}

function reinitializePanelWidgets(panel) {
    $(panel).find('.textarea').each(function () {
        $(this).wysihtml5();
    });
    $(panel).find('#calendar').each(function () {
        // The Calender
        $(this).datepicker();
    });
    $(panel).find('#chat-box').each(function () {
        // The Calender
        // SLIMSCROLL FOR CHAT WIDGET
        $(this).slimScroll({
            height: '250px'
        });
    });
}

function mainSearch() {
    var q = $('#main-search-q').val();
    if (typeof q === 'undefined' || q == '') {
        alert('No query for search! Ignored.');
    } else {
        var url = '/' + moduleName + '/search/index?query=' + q;
        getContent(url, '<i class="fa fa-search"></i> ' + q, false);
    }
}

function getContent(elem, name, reloadable, log = true, scrollToTop = true) {
    var url = null;
    var realName = name.replace(/\\([\\'"])/g, '$1')
    if (jQuery.type(elem) === "string") {
        url = elem;
    } else {
        url = $(elem).attr('href');
    }
    if (!checkTabExists(realName)) {
        $("#admin-content").dstabs('add', url, realName);
        var newTab = $("#admin-content-tabs li:last");

        if ((typeof reloadable === 'undefined' || reloadable)) {
            newTab.attr('reloadable', true);
        } else {
            newTab.attr('reloadable', false);
        }
//        var index=$("#admin-content").tabs("length");
        //$("body").scrollTop();
        if (scrollToTop) {
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        }
//---------------
        if (log) {
            var postdata = 'ModuleTabsHistory[href]' + '=' + url + '&' + 'ModuleTabsHistory[name]' + '=' + realName;
            var logUrl = '/' + moduleName + '/moduleTabsHistory/log';
            setTimeout(function () {
                $.post(logUrl, postdata, function (data) {
                    setTimeout(function () {
                        try {
                            $.fn.yiiGridView.update('admin-tabs-history-grid');
                        } catch (e) {
                            console.log('Some trables in pages history - recovered');
                        }
                    }, 3000);
                }, "text");
            }, 30000);
        }
//---------------
    }
}

function checkTabExists(str) {
    var result = false;
    var p = $("#admin-content ul li a :contains(" + str + ")");
    if (p.length) {
        var id = p.parent().parent().index();
        $("#admin-content").dstabs("select", id);
        result = true;
    }
    return result;
}

function closeSelectedTab() {
    var adminTabs = $("#admin-content");
    var selected = adminTabs.dstabs('option', 'selected');
    adminTabs.dstabs('remove', selected);
}

function reloadSelectedTab(event) {
    var adminTabs = $("#admin-content");
    var selectedTabIndex = adminTabs.dstabs('option', 'active');
    if (event) {
        event.preventDefault();
    }
    forceReload = true;
    adminTabs.dstabs('reload', selectedTabIndex);
}

function reloadSelectedTabOnF5(e) {
    var result = true;
    if (e.which == 116) {
        e.preventDefault();
        reloadSelectedTab(event);
        result = false;
    }
    return result;
}

$(document).bind("keydown", reloadSelectedTabOnF5);

// === Translation ======================
function editTranslation(evt, obj, type, id, mode) {
//$("#sort_by").change(function() {
//    TranslateForm_cn
    var baseUrl = $(obj).attr('url');
    var to = $(obj).attr('to');
    var url = baseUrl + '?type=' + type + '&id=' + id + '&mode=' + mode + '&language=' + to;
    if (url[0] != '/') {
        url = 'http://' + url;
    }
    $("#TranslateForm_type").val(type);
    $("#TranslateForm_mode").val(mode);
    $("#TranslateForm_id").val(id);
    var from = $(obj).attr('from');
    $("#TranslateForm_from").val(from);
    $("#TranslateForm_to").val(to);
    $("#TranslateForm_url").val(url);
    $.getJSON(url, function (data) {
        if ((data !== null) && (typeof data !== 'undefined') && (data.source != '')) {
            $("#TranslateForm_source").val(data.source);
            $("#TranslateForm_message").val(data.message);
            var iframe = $('#translate-bkrs');
            if (iframe.length) {
                if (from == 'zh') {
                    var fUrl = 'https://bkrs.info/slovo.php?ch=' + data.source;
                } else {
                    var fUrl = 'https://bkrs.info/slovo.php?' + from + '=' + data.source;
                }
                iframe.attr('src', fUrl);
            }
            $("#translationDialog").dialog("open");
            stopPropagation(evt);
        } else {
            dsAlert('Перевод не найден!', '', true);
        }
    });
    return false;
}

function saveTranslation() {
    var spanBlock = $("#TranslateForm_type").val() + $("#TranslateForm_id").val() + $("#TranslateForm_mode").val();
    var message = $("#TranslateForm_message").val();
    $('#' + spanBlock).text(message);
    var postform = $("#translation-form").serialize();
    var url = $("#TranslateForm_url").val();
    $.post(url, postform);
    $("#translationDialog").dialog("close");
    return false;
}

function stopPropagation(evt) {
    var ev = evt ? evt : window.event;
    if (ev.stopPropagation) ev.stopPropagation();
    if (ev.cancelBubble != null) ev.cancelBubble = true;
}

function updateAdminNews() {
    //var exists = $('#grid-admin-news-desktop') != 'unsigned';
    var exists = typeof $('#grid-admin-news-desktop') !== 'undefined';
    if (exists) {
        //$.fn.yiiGridView.update('grid-admin-news-desktop');
    }
    // setTimeout(updateAdminNews, 300000);
}

function fixTabPanelLayout(panel) {
    var headerHeight = $('#admin-content-tabs').outerHeight(true) || 0;
    var wrapperHeight = $('.content-wrapper').height();
    var panelMinHeight = wrapperHeight - headerHeight - 20; //.content padding etc
    $(panel).css('min-height', panelMinHeight);

};

function fixYandexMapScroll(yandexMapBlock) {
    var YandexMap = yandexMapBlock;
    var mapTitle = document.createElement('div');
    mapTitle.className = 'mapTitle';
    // вписываем нужный нам текст внутрь элемента
    mapTitle.textContent = 'Для активации карты нажмите по ней';
    // добавляем элемент с подсказкой последним элементов внутрь нашего <div> с id YandexMap
    YandexMap.appendChild(mapTitle);
    // по клику на карту
    $(YandexMap).on('click', function () {
        // убираем атрибут "style", в котором прописано свойство "pointer-events"
        this.children[0].removeAttribute('style');
        // удаляем элемент с интерактивной подсказкой
        if ($(mapTitle.parentElement).length > 0) {
            mapTitle.parentElement.removeChild(mapTitle);
        }
    });
    // по движению мыши в области карты
    $(YandexMap).on('mousemove', function (event) {
        // показываем подсказку
        mapTitle.style.display = 'block';
        // двигаем подсказку по области карты вместе с мышкой пользователя
        if (event.offsetY > 10) mapTitle.style.top = event.offsetY + 20 + 'px';
        if (event.offsetX > 10) mapTitle.style.left = event.offsetX + 20 + 'px';
    });
    // при уходе указателя мыши с области карты
    $(YandexMap).on('mouseleave', function () {
        // прячем подсказку
        mapTitle.style.display = 'none';
    });
};