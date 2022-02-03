$(document).ready(function () {

});

$('body').on('change', '.catalog', function () {
    var ajx = $('#ajx').val();
    if (ajx == 1)
        return true;
    else {
        $('#ajx').val(1);

        var lvlid = $(this).attr('id');
        var parid = $(this).val();
        var tmp = lvlid.split('_');

        if ($('.l_' + tmp[1]).hasClass('l_last')) {
            getSelData(lvlid, parid);
        }
        else {
            var flag = false;
            $('.any_level').each(function () {
                var cl = $(this).attr('class').split(' ');

                if (flag) {
                    $(this).slideUp('slow', function () {
                        $(this).remove();
                    });
                }

                if (cl[1] == 'l_' + tmp[1])
                    flag = true;
            });

            getSelData(lvlid, parid);
        }
    }
});

/********************************************************* totop */
$('body').on('click', '.totop', function () {

    var thislev = $(this).parent().parent();
    var uplev = thislev.prev();
    var upid = uplev.attr('class').split(' ');
    var cat_txt = $('.cat-text').html();

    cat_txt = cat_txt.substr(0, (function (s) {
        var idx = cat_txt.lastIndexOf('/');
        if (idx < 0) idx = s.length;
        return idx;
    })(cat_txt));

    thislev.slideUp('slow', function () {
        thislev.remove();

        if (upid[1] == 'l_1') {
            uplev.find('.ardn').show();
        }
        else
            uplev.find('.arrows').show();
    });
    uplev.removeClass(upid[1]);
    uplev.addClass('l_last');
    if (chkTaboo()) {
        $('.cat-text').fadeOut(function () {
            $('.cat-text').html(cat_txt);
            $('.cat-text').fadeIn();
        });
    }

});

/********************************************************* tobot */
$('body').on('click', '.tobot', function () {
    var ajx = $('#ajx').val();
    if (ajx == 1)
        return true;
    else {
        $('#ajx').val(1);

        var thislev = $(this).parent().parent();
        var tmp = thislev.find('select').attr('id').split('_');
        var lvl = parseInt(tmp[1]);
        var pid = thislev.find('select').val();

        $.ajax({
            type: 'POST',
            url: JS_tobot_url,
            data: {level: lvl, parent: pid},
            dataType: 'json',
            // Deferred methods: .success() becomes .done(), .error() becomes .fail(), and .complete() becomes .always().
            beforeSend: function () {
                $('div.cat_' + lvl).show();
                $('.arrows').hide();
                $('.cat-text').fadeOut();
            },
            done: function (res) {
                $('div.cat_' + lvl).hide();
                thislev.removeClass('l_last');
                thislev.addClass('l_' + lvl);
                thislev.after(res.levels);

                var newlev = $('.l_' + (lvl + 1));
                newlev.hide();
                newlev.removeClass('l_' + (lvl + 1));
                newlev.addClass('l_last');
                newlev.slideDown('slow');

                newlev.find('.arrows').show();
                if (!res.child) {
                    newlev.find('.ardn').hide();
                }
                if (chkTaboo()) {
                    $('.cat-text').html(res.cat_text);
                    $('.cat-text').fadeIn();
                }
                setTimeout(function () {
                    $('#ajx').val(0)
                }, 1000);
            },
            fail: function () {
                alert('error', JS_ajax_error);

                setTimeout(function () {
                    $('#ajx').val(0)
                }, 1000);
            }
        });
    }
});

/************************************************** functions */
function getSelData(lvl_id, parent_id) {
    var lvl = lvl_id.split('_');

    $.ajax({
            type: 'POST',
            url: JS_seldata_url,
            data: {level: lvl[1], parent: parent_id},
            dataType: 'json',
        // Deferred methods: .success() becomes .done(), .error() becomes .fail(), and .complete() becomes .always().
            beforeSend: function () {
                $('div.cat_' + lvl[1]).show();
                $('.arrows').hide();
                $('.cat-text').fadeOut();
            },
            done: function (res) {
                $('div.cat_' + lvl[1]).hide();
                var par = $('div.cat_' + lvl[1]).parent();
                par.removeClass('l_' + lvl[1]);
                par.addClass('l_last');
                par.find('.arup').show();

                if (res.child)
                    par.find('.ardn').show();

                if (chkTaboo()) {
                    $('.cat-text').html(res.cat);
                    $('.cat-text').fadeIn();
                }

                setTimeout(function () {
                    $('#ajx').val(0)
                }, 1000);
            },
        fail: function () {
                alert('error', JS_ajax_error);

                setTimeout(function () {
                    $('#ajx').val(0)
                }, 1000);
            }
        });
}

function chkTaboo() {
    $('.cat-text').removeClass('errorMessage');
    $('.modal-footer').find('button').attr('disabled', false);

    if($('#is_create').val()==0) {

        var newcat = '';
        var thiscat = $('#menu_id').val();


        var lastcat = $('.dotted-field-up').find('.l_last');
        var newcat = lastcat.find('select').val();

        if (thiscat == newcat) {
          lastcat.find('.ardn').fadeOut();
            $('.cat-text').addClass('errorMessage');
            $('.cat-text').html(JS_taboo_msg);
            $('.cat-text').fadeIn();
            $('.modal-footer').find('button').attr('disabled', 'disabled');
            return false;
        }
    }

    return true;
}
