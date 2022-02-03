$(document).ready(function () {
    setTimeout(checkOrder, 600000);
});

function checkOrder() {
    /*    var uid = $("#manager_id").val();
     $.get('/admin/main/checkOrder/uid/' + uid, function (data) {
     if (data) {
     var html = '<div id="order-notice">' +
     '<a href="/admin/orders/view" id="notice' + data + '" onclick="openOrder(' + data + ', ' + uid + ');return false;">У вас новый заказ!</a></div>';
     $("body").append(html);
     }
     else {
     setTimeout(checkOrder, 300000);
     }

     });
     */
}

function refund(pid) {
    if (confirm('Вы уверены что хотите отменить данный товар?')) {
        var text = $("#comment_" + pid).val();
        var url = '/admin/orders/refund/pid/' + pid + '/msg/' + text;

        $.get(url, function (data) {
            alert(data);
            reloadSelectedTab(event);
        });
    }
}

function deleteFeaturedItem(dellink, id) {
    var url = $(dellink).attr('href');
    var elem = $("#item" + id);
    $.get(url, null,
        function (data) {
            $(elem).remove();
            alert(data);
        },
        "text");
}

function loadCatalogFromSrc(src) {
        //var form = $('#form-menu');
        dsProgress('Loading...','Update') ;
        var postdata = 'src='+src;// form.serialize() + '&loadFromTaobao=1';
        var url = '/admin/menu/loadFromSrc' //form.attr('action');
        var jqxhr = $.post(url, postdata, function (data) {
            dsAlert(data,'Update',true);
        }, "text")
            .fail(function() {
                dsAlert('Error ocured!','Update',true);
            })
            .always(function() {
                reloadSelectedTab(event);//$.fn.yiiGridView.update('menu-sources-grid');
            });
}

function copyCatalogTreeToMenu(id) {
    //var form = $('#form-menu');
        var postdata = 'id=' + id;// form.serialize() + '&loadFromTaobao=1';
        var url = '/admin/source/copyCatalogTreeToMenu' //form.attr('action');
        $.post(url, postdata, function (data) {
            dsAlert(data, 'Update', true);
        }, "text");
}


var res = false;

function updateMetaAndHFURLStep(url, offset, count, post, internal,totalCount) {
    if (internal) {
        $('#jsupdate-res').html('Internal categories updated: ' + offset + ' (' + Math.round(100*offset / totalCount) + '%)');
    } else {
        $('#jsupdate-res').html('Virtual categories updated: ' + offset + ' (' + Math.round(100*offset / totalCount) + '%)');
    }
    var postdata = post + 'updateHFURL=1&offset=' + offset + '&count=' + count + '&internal=' + internal;
    $.post(url, postdata, function (data) {
        res = data;
        offset = offset + count;
        if ((res !== 'DONE')) {//&& (offset < totalCount+1000)
            setTimeout(function () {
                updateMetaAndHFURLStep(url, offset, count, post, internal,totalCount)
            }, 1000);
        } else {
            if (internal) {
                $('#jsupdate-res').html('Internal categories update: COMPLETE!');
                alert('All categories update: COMPLETE!');
            } else {
                $('#jsupdate-res').html('Virtual categories update: COMPLETE!');
            }
            if (!internal) {
                    $('#jsupdate-res').html('Virtual categories update: COMPLETE!');
                    alert('All categories update: COMPLETE!');
            }
        }
    }, "text");
}

function updateMetaAndHFURL(totalCount) {
    if (confirm("Все старые значения meta и HFURL будут удалены. Продолжить?")) {
        var post = 'updateHFURL=1';
        var url = '/admin/menu/updateHFURL';
        var offset = 0;
        var count = 10;
        res = false;
        setTimeout(function () {
            updateMetaAndHFURLStep(url, offset, count, post, false,totalCount);
        }, 1000);
    }
}

function updateBrandMeta() {
    if (confirm("Все старые значения meta будут удалены. Продолжить?")) {
        var url = '/admin/brands/updateMeta';
        $.get(url, function (data) {
            if (data==='OK') {
                alert('Brands meta update: COMPLETE!');
            } else {
                alert('Brands meta update: ERROR!');
            }
        }, "text");

    }
}

function saveSid(sendButton) {
    var url = $(sendButton).parents('form').attr('action');
    var postform = $(sendButton).parents('form').serialize();
    var elem = $(sendButton).parents('.ui-tabs-panel');
    $.post(url, postform,
        function (data) {
            $(elem).html(data);
        },
        "html");
}

function seeOrderSum(id) {
    var form = $('#manager-order-sum-' + id);
    var postform = form.serialize() + '&uid=' + id;
    var date_from = !form.find('#date_from').val();
    var date_to = !form.find('#date_to').val();
    if (date_from || date_to) {
        alert("Введите даты");
    } else {
        var url = form.attr('action');
        $.post(url, postform, function (data) {
            $('#ordersSum' + id).html(data);
        }, "html");
    }
}

function deleteMainMenu(id) {
    if (confirm('Удалить категорию и все её дочерние категории?')) {
        var url = '/admin/menu/deleteex/?id=' + id;
        var adminTabs = $("#admin-content");
        var tbid = adminTabs.tabs('option', 'selected');
        $.get(url, function () {
            alert("Категория ID:" + id + " удалена");
        });
        adminTabs.tabs("remove", tbid);
        adminTabs.tabs("refresh");
    }
}

function createMainMenu(id) {
    if (confirm('Добавить новую дочернюю категорию в текущую?')) {
        var url = '/admin/menu/createex/?id=' + id;
        $.getJSON(url, function (data) {
            getContent('/ru/admin/menu/update/id/' + data.id, 'Категория №' + data.id,false);
            return false;
        });
    }
    return false;
}

function updateCrone(sendButton) {
    var url = $(sendButton).parents('form').attr('action');
    var postform = $(sendButton).parents('form').serialize();
    var elem = $(sendButton).parents('.ui-tabs-panel');
    $.get(url, postform,
        function (data) {
            $(elem).append(data);
        },
        "html");
}

// Used
function clearCache(sendButton) {
    var postform = null;
    var url = $(sendButton).attr('formaction');
//    if(typeof url == "undefined"){
// url = $(sendButton).parents('form').attr('action');
// postform = $(sendButton).parents('form').serialize();
// }
    $.get(url, postform,
        function (data) {
            reloadSelectedTab(event);
            alert(data);
        },
        "text");
}

// Used
function clearMenuCache() {
    var postform = null;
    var url = '/ru/admin/cache/clear/all/2';
//    if(typeof url == "undefined"){
// url = $(sendButton).parents('form').attr('action');
// postform = $(sendButton).parents('form').serialize();
// }
    $.get(url, postform,
        function (data) {
            reloadSelectedTab(event);
            alert(data);
        },
        "text");
}

//used
function UpdateParamFromProxy(id) {
    var url = '/admin/config/updateparamfromproxy/param/' + id;
    // alert(url);
    $.get(url, function (data) {
        alert(data);
        var active = $("#admin-content").tabs("option", "selected");
        $("#admin-content").tabs("load", active);
    }, "text");
}

//Used
function searchArticles(sendButton) {
    var url = $(sendButton).parents('form').attr('action');
    var postform = $(sendButton).parents('form').serialize();
    var elem = $(sendButton).parents('.ui-tabs-panel');
    $.get(url, postform,
        function (data) {
            $(elem).html(data);
        },
        "html");
}

//Used
function searchCategories(sendButton) {
    var url = $(sendButton).parents('form').attr('action');
    var postform = $(sendButton).parents('form').serialize();
    var elem = $(sendButton).parents('.ui-tabs-panel');
    $.get(url, postform,
        function (data) {
            $(elem).html(data);
        },
        "html");
}
//===========================
//Used
function saveCategory(id) {
    var postform = $('#category-form-' + id).serialize();
    var url = $('#category-form-' + id).attr('action');
    $.post(url, postform, function (data) {
        alert(data);
    }, "text");
}

//Used
function saveMainMenu(id) {
    var postform = $('#menu-form-' + id).serialize();
    var url = $('#menu-form-' + id).attr('action');
    $.post(url, postform, function (data) {
        alert(data);
    }, "text");
}

//Used
function saveOperator(id) {
    var postform = $('#operator-form-' + id).serialize();
    var url = $('#operator-form-' + id).attr('action');
    $.post(url, postform, function (data) {
        alert(data);
    }, "text");
}

//Used
function saveQuestionForm(id) {
    var postform = $('#message-answer-' + id).serialize();
    var url = $('#message-answer-' + id).attr('action');
    $.post(url, postform, function (data) {
        alert(data);
        $('#message-answer-' + id).parents(".view").removeClass("answer").find('input').attr('disabled', 'disabled');
    }, "text");
}

//used
function savePaySystem(id) {
    var postform = $('#pay-systems-form-' + id).serialize();
    var url = $('#pay-systems-form-' + id).attr('action');
    $.post(url, postform, function (data) {
        alert(data);
    }, "text");
}

//Used
function saveForm(id) {
    var form = $("[id='"+id+"']");
    var postform = $(form).serialize();
    var url = $(form).attr('action');
    $.post(url, postform, function (data) {
        alert(data);
    }, "text");
}

function cmsHistoryRestore(id) {
    if (confirm("Восстановить контент из истории изменений?")) {
        //var form = $('#form-menu');
        var postdata = 'id=' + id;
        url = '/admin/cmsHistory/restore';
        $.post(url, postdata, function (data) {
            alert(data);
            reloadSelectedTab(event);
        }, "text");
    }
}

// Used
function saveConfig(id) {
    var postform = $('#config-form-' + id).serialize();
    var url = $('#config-form-' + id).attr('action');
    $.post(url, postform, function (data) {
        alert(data);
    }, "text");
}
//======================================================
//Used
function showControll(name, id) {
    $(".controll-form-" + id).slideUp('slow');
    $("#" + name + "-form-" + id).slideDown('slow');
}

function menuStorageCommand(command, name) {
    if (command === 'save') {
        message = 'Вы уверены, что хотите сохранить категории под именем "' + name + '"?';
    } else if (command === 'delete') {
        message = 'Вы уверены, что хотите удалить категории под именем "' + name + '"?';
    } else if (command === 'restore') {
        message = 'Вы уверены, что хотите восстановить категории под именем "' + name + '"?';
    } else {
        alert('Ошибка обработки сохраненных каталогов!');
        return;
    }
    if (confirm(message)) {
        url = '/admin/menu/storage/command/' + command + '/name/' + name;
        $.get(url, function (data) {
            alert(data);
            reloadSelectedTab(event);
        });
    }
}

function searchForWarehouse(formId,blockId) {
    var url = $('#'+formId).attr('action');
    var postform = $('#'+formId).serialize();
    $.post(url, postform,
        function (data) {
            $('#'+blockId).html(data);
        },
        "html");
}

function generateOrderCustomXlsToMail(id,fileName,uid) {
    var postdata = 'email=' + uid;
        url = '/admin/orders/GenerateCustomXls?id='+id+'&fileName='+fileName;
        $.post(url, postdata, function (data) {
            alert(data);
        }, "text");
}

function parseUrlToMenuCategory(urlInputId,cidInputId,queryInputId) {
    var parseUrl = $('#'+urlInputId).val();
    var postdata = 'url=' + encodeURIComponent(parseUrl);
    url = '/admin/menu/parseUrlToMenuCategory';
    $.post(url, postdata, function (data) {
        if (data.result!=0) {
            $('#'+cidInputId).val(data.cid);
            $('#'+queryInputId).val(data.query);
        }
        alert(data.message);
    }, "json");
}

function saveLocalItem(formId) {
    var postform = $("#"+formId).serialize();
    var url = '/admin/shop/itemSave';
    $.post(url, postform,function (data) {
        alert(data);
    },'html');
}